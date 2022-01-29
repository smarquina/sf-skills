<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command;


use App\Service\Project\AddProjectRequest;
use App\Service\Project\AddProjectService;
use App\Utils\Validator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * A console command that creates users and stores them in the database.
 *
 * To use this command, open a terminal window, enter into your project
 * directory and execute the following:
 *
 *     $ php bin/console app:add-user
 *
 * To output detailed information, increase the command verbosity:
 *
 *     $ php bin/console app:add-user -vv
 *
 * See https://symfony.com/doc/current/console.html
 *
 * We use the default services.yaml configuration, so command classes are registered as services.
 * See https://symfony.com/doc/current/console/commands_as_services.html
 *
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
#[AsCommand(
    name: 'project:add',
    description: 'Creates projects and stores them in the database'
)]
class AddProjectCommand extends Command {
    private SymfonyStyle $io;

    public function __construct(
        private AddProjectService $service,
        private Validator         $validator,
    )
    {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setHelp($this->getCommandHelp())
            // commands can optionally define arguments and/or options (mandatory and optional)
            // see https://symfony.com/doc/current/components/console/console_arguments.html
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the new project')
            ->addArgument('amount', InputArgument::OPTIONAL, 'The amount of the project')
            ->addArgument('start_date', InputArgument::OPTIONAL, 'The start date of the project');
    }

    /**
     * This optional method is the first one executed for a command after configure()
     * and is useful to initialize properties based on the input arguments and options.
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        // SymfonyStyle is an optional feature that Symfony provides so you can
        // apply a consistent look to the commands of your application.
        // See https://symfony.com/doc/current/console/style.html
        $this->io = new SymfonyStyle($input, $output);
    }

    /**
     * This method is executed after initialize() and before execute(). Its purpose
     * is to check if some of the options/arguments are missing and interactively
     * ask the user for those values.
     *
     * This method is completely optional. If you are developing an internal console
     * command, you probably should not implement this method because it requires
     * quite a lot of work. However, if the command is meant to be used by external
     * users, this method is a nice way to fall back and prevent errors.
     */
    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->io->title('Add User Command Interactive Wizard');
        $this->io->text([
                            'If you prefer to not use this interactive wizard, provide the',
                            'arguments required by this command as follows:',
                            '',
                            ' $ php bin/console app:add-user username password email@example.com',
                            '',
                            'Now we\'ll ask you for the value of all the missing command arguments.',
                        ]);

        // Ask for the username if it's not defined
        $name = $input->getArgument('name');
        if (null !== $name) {
            $this->io->text(" > <info>Username</info>: {$name}");
        } else {
            $username = $this->io->ask('Name', null, [$this->validator, 'validateName']);
            $input->setArgument('name', $username);
        }

        // Ask for the amount if it's not defined
        $amount = $input->getArgument('amount');
        if (null !== $amount) {
            $this->io->text(" > <info>Password</info>: {$amount}");
        } else {
            $amount = $this->io->ask('Amount (as int, no decimals)', null, [$this->validator, 'validateAmount']);
            $input->setArgument('amount', $amount);
        }

        // Ask for the start date if it's not defined
        $startDate = $input->getArgument('start_date');
        if (null !== $startDate) {
            $this->io->text(" > <info>Start Date</info>: {$startDate}");
        } else {
            $email = $this->io->ask('Start date (d-m-Y)', null, [$this->validator, 'validateStartDate']);
            $input->setArgument('start_date', $email);
        }
    }

    /**
     * This method is executed after interact() and initialize(). It usually
     * contains the logic to execute to complete this command task.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('add-project-command');

        $name      = $input->getArgument('name');
        $amount    = (int)$input->getArgument('amount');
        $startDate = $input->getArgument('start_date');

        $project = $this->service->handle(
            new AddProjectRequest($name, $amount, $startDate)
        );


        $this->io->success("{$name} was successfully created");

        $event = $stopwatch->stop('add-project-command');
        if ($output->isVerbose()) {
            $this->io->comment(sprintf('New user database id: %d / Elapsed time: %.2f ms / Consumed memory: %.2f MB', $project->getId(), $event->getDuration(), $event->getMemory() / (1024 ** 2)));
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
            The <info>%command.name%</info> command creates new projects and saves them in the database:

            HELP;
    }
}
