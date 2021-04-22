<?php

namespace Guess\Application\League;

use Exception;
use Guess\Application\Services\FileUploaderInterface;
use Guess\Domain\League\League;
use Guess\Domain\League\LeagueRepositoryInterface;

class CreateLeagueHandler
{
    private const BUCKET_NAME = 'guess-league-logos';

    public function __construct(
        private LeagueRepositoryInterface $repository,
        private FileUploaderInterface $logoUploader,
    ) {
    }

    /**
     * @param array $data
     * @throws Exception
     */
    public function handle(array $data): void
    {
        if ($this->repository->findOneBy(['name' => $data['name']])) {
            throw new Exception("League \"{$data['name']}\" has already been saved");
        }
        if (empty($data['logo'])) {
            throw new Exception('We need League logo to save the League');
        }

        $this->logoUploader->upload(self::BUCKET_NAME, $data['name'], $data['logo']);

        try {
            $this->repository->save(
                (new League())
                    ->setName($data['name'])
                    ->setLogo($this->logoUploader->getImageUrl())
                    ->setLeagueApiId($data['league_api_id'])
                    ->setLeagueNameSlugged($data['league_name_slugged'])
            );
        } catch (Exception) {
            throw new Exception('League cannot be saved');
        }
    }
}
