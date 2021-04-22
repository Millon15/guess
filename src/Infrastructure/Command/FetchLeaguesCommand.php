<?php

namespace Guess\Infrastructure\Command;

use Exception;
use Guess\Application\League\CreateLeagueHandler;
use Guess\Infrastructure\Services\FetchLeaguesInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchLeaguesCommand extends Command
{
    protected static $defaultName = 'app:fetch-leagues';

    public function __construct(
        private CreateLeagueHandler $createHandler,
        private FetchLeaguesInterface $fetcherService,
        ?string $name = null,
    ) {
        parent::__construct($name);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $leagues = $this->fetcherService->fetch();
        foreach ($leagues as $league) {
            try {
                $this->createHandler->handle($league);
                $output->writeln("{$league['name']} saved");
            } catch (Exception $e) {
                $output->writeln($e->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}
