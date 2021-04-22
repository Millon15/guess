<?php

namespace Guess\Application\Player;

use Exception;
use Guess\Domain\Player\Player;
use Guess\Domain\Player\PlayerRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreatePlayerHandler
{
    public function __construct(
        private PlayerRepositoryInterface $repository,
        private UserPasswordEncoderInterface $encoder,
    ) {
    }

    /**
     * @param array $data
     * @throws Exception
     */
    public function handle(array $data): void
    {
        $player = (new Player())
            ->setUsername($data['username'])
            ->setAvatar($data['avatar'])
            ->setEmail($data['email']);
        $player->setPassword($this->encoder->encodePassword($player, $data['password']));

        try {
            $this->repository->save($player);
        } catch (Exception) {
            throw new Exception('User cannot be saved');
        }
    }
}
