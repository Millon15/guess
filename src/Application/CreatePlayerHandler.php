<?php

namespace Guess\Application;

use Exception;
use Guess\Domain\Player\Player;
use Guess\Domain\Player\PlayerRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreatePlayerHandler
{
    public function __construct(
        private PlayerRepositoryInterface $playerRepository,
        private UserPasswordEncoderInterface $encoder,
    ) {
    }

    /**
     * @param array $playerData
     * @throws Exception
     */
    public function handle(array $playerData): void
    {
        $player = (new Player())
            ->setUsername($playerData['username'])
            ->setAvatar($playerData['avatar'])
            ->setEmail($playerData['email']);
        $player->setPassword($this->encoder->encodePassword($player, $playerData['password']));

        try {
            $this->playerRepository->save($player);
        } catch (Exception) {
            throw new Exception('User cannot be saved');
        }
    }
}
