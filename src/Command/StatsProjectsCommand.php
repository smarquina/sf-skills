<?php

namespace App\Command;


use App\Service\Project\Stats\StatsProjectsService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * A console command that retrieves projects stats.
 *
 * To use this command, open a terminal window, enter into your project
 * directory and execute the following:
 *
 *     $ php bin/console project:stats
 *
 * To output detailed information, increase the command verbosity:
 *
 *     $ php bin/console project:stats -vv
 *
 */
#[AsCommand(
    name: 'project:stats',
    description: 'Get projects stats'
)]
class StatsProjectsCommand extends Command {
    private SymfonyStyle $io;

    public function __construct(
        private StatsProjectsService $service
    )
    {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setHelp($this->getCommandHelp());
    }

    /**
     * This optional method is the first one executed for a command after configure()
     * and is useful to initialize properties based on the input arguments and options.
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }


    /**
     * This method is executed after interact() and initialize(). It usually
     * contains the logic to execute to complete this command task.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('stats-project-command');


        $stats = $this->service->handle();

        $this->io->info(sprintf("there are %d projects with %.2f as total amount",
                                   $stats->getTotalProjects(),
                                   $stats->getPrintableTotalAmount()));

        $event = $stopwatch->stop('stats-project-command');
        if ($output->isVerbose()) {
            $this->io->comment(sprintf('Elapsed time: %.2f ms / Consumed memory: %.2f MB', $event->getDuration(), $event->getMemory() / (1024 ** 2)));
        }

        return Command::SUCCESS;
    }

    /**
     * The command help is usually included in the configure() method, but when
     * it's too long, it's better to define a separate method to maintain the
     * code readability.
     */
    private function getCommandHelp(): string
    {
        return <<<'HELP'
            The <info>%command.name%</info> command retrieves all projects stats:

            HELP;
    }
}
