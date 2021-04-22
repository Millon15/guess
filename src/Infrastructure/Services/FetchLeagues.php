<?php

namespace Guess\Infrastructure\Services;

use DateTimeImmutable;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FetchLeagues implements FetchLeaguesInterface
{
    protected const allowedSluggedLeagueNames = [
        'premier-league',
        'serie-a',
        'primera-division', /* La Liga */
        'primeira-liga', /* Liga Portugal */
        'super-lig',
        'uefa-europa-league',
        'uefa-champions-league',
        'uefa-nations-league',
        'bundesliga-1',
        'ligue-1', /* France Ligue 1 */
    ];
    protected const allowedCountryNames = [
        'England',
        'Italy',
        'France',
        'Portugal',
        'Spain',
        'Turkey',
        'World',
        'Germany',
    ];

    public function __construct(
        private ProviderInterface $provider,
    ) {
    }

    private function getContent(array $criteria): array
    {
        $response = [];
        if (!$criteria) {
            $response = $this->provider->getLeaguesBySeason((int)(new DateTimeImmutable())->format('Y'));
        }
        if (isset($criteria['league-api-id'])) {
            $response = $this->provider->getTeamsByLeagueApiId((int)$criteria['league-api-id']);
        }
        if (isset($criteria['days'])) {
            $response = $this->provider->getGamesByDays((int)$criteria['days']);
        }
        return $response;
    }

    public function fetch(array $criteria = []): array
    {
        $content = $this->getContent($criteria);

        $leagues = [];
        foreach ($content['api']['leagues'] as $league) {
            $sluggedLeagueName = strtolower(
                (new AsciiSlugger())->slug($league['name'])->toString()
            );
            if (!in_array($sluggedLeagueName, static::allowedSluggedLeagueNames, true)
                || !in_array($league['country'], static::allowedCountryNames, true)
            ) {
                continue;
            }

            $leagues[] = [
                'leagueApiId' => $league['league_id'],
                'name' => $league['name'],
                'logo' => $league['logo'],
                'leagueNameSlugged' => $sluggedLeagueName
            ];
        }
        return $leagues;
    }
}
