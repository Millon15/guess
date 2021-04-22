<?php

namespace Guess\Domain\League;

interface LeagueRepositoryInterface
{
    public function save(League $league): void;

    public function findOneBy(array $array);
}
