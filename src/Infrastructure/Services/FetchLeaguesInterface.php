<?php

namespace Guess\Infrastructure\Services;

interface FetchLeaguesInterface
{
    public function fetch(array $criteria = []): array;
}
