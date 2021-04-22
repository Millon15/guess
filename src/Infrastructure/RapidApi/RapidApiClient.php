<?php

namespace Guess\Infrastructure\RapidApi;

use DateTimeImmutable;
use Exception;
use Guess\Infrastructure\Services\ProviderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Utils;

class RapidApiClient implements ProviderInterface
{
    private const API_FOOTBALL_URI_LEAGUES = 'https://api-football-v1.p.rapidapi.com/v2/leagues/season/';
    private const API_FOOTBALL_URI_TEAMS = 'https://api-football-v1.p.rapidapi.com/v2/teams/league/';
    private const API_FOOTBALL_URI_GAMES = 'https://api-football-v1.p.rapidapi.com/v2/fixtures/date/';

    private Client $httpClient;

    public function __construct(string $apiKey)
    {
        $this->httpClient = new Client([
            'headers' => ['X-RapidAPI-Key' => $apiKey],
        ]);
    }

    public function getLeaguesBySeason(int $seasonYear): array
    {
        $response = $this->httpClient->request('GET', self::API_FOOTBALL_URI_LEAGUES);
        return $this->decodeResponse($response);
    }

    public function getTeamsByLeagueApiId(int $leagueApiId): array
    {
        $url = self::API_FOOTBALL_URI_TEAMS . $leagueApiId;
        $response = $this->httpClient->request('GET', $url);
        return $this->decodeResponse($response);
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getGamesByDays(int $days): array
    {
        $url = self::API_FOOTBALL_URI_GAMES .
            (new DateTimeImmutable("$days day"))
                ->format('Y-m-d');
        $response = $this->httpClient->request('GET', $url);
        return $this->decodeResponse($response);
    }

    /**
     * @param Response $response
     * @return array
     * @noinspection NullPointerExceptionInspection
     */
    private function decodeResponse(Response $response): array
    {
        $content = $response->getBody()->getContents();
        return $content ? Utils::jsonDecode($content, true) : [];
    }
}
