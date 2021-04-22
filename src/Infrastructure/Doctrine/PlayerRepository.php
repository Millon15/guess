<?php

namespace Guess\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Guess\Domain\Player\Player;
use Guess\Domain\Player\PlayerRepositoryInterface;

class PlayerRepository extends ServiceEntityRepository implements PlayerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    /**
     * @param Player $model
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Player $model): void
    {
        $this->_em->persist($model);
        $this->_em->flush();
    }
}
