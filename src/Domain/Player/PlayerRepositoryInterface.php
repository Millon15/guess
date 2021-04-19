<?php

namespace Guess\Domain\Player;

interface PlayerRepositoryInterface
{
    public function save(Player $player): void;
}
