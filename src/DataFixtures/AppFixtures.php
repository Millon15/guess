<?php

namespace Guess\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Guess\Domain\League\League;
use Guess\Domain\Player\Player;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordEncoderInterface $encoder
    ) {
    }

    public function load(ObjectManager $manager)
    {
        $league = (new League())
            ->setId(1)
            ->setName('Premier League')
            ->setLeagueNameSlugged('premier-league')
            ->setLeagueApiId(123)
            ->setLogo('premier-league-logo.png');
        $manager->persist($league);

        $player = (new Player())
            ->setUsername('firstone')
            ->setEmail('firstone@email.com');
        $player->setPassword($this->encoder->encodePassword($player, '123123'));
        $manager->persist($player);

        $manager->flush();
    }
}
