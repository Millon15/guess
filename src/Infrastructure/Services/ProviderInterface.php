<?php

namespace Guess\Infrastructure\Services;

interface ProviderInterface
{
    public function getLeaguesBySeason(int $seasonYear): array;

    public function getTeamsByLeagueApiId(int $leagueApiId): array;

    public function getGamesByDays(int $days): array;
}
