<?php

namespace App\Tests\Command\Project;

use App\Command\AddProjectCommand;
use App\Repository\Project\ProjectRepository;
use App\Tests\Command\AbstractCommandTest;
use App\Utils\Validator\Project\Validator;

class AddProjectCommandTest extends AbstractCommandTest {

    private ProjectRepository $projectRepository;
    private Validator         $projectValidator;
    private array             $projectData;

    protected function setUp(): void
    {
        $this->projectRepository = self::getContainer()->get(ProjectRepository::class);
        $this->projectValidator  = new Validator();
        $this->projectData       = ['name'       => 'project_test',
                                    'amount'     => '5000000', //50.000,00
                                    'start_date' => '01-01-2000'];

        parent::setUp();

    }

    protected function getCommandFqcn(): string
    {
        return AddProjectCommand::class;
    }

    /**
     *
     * This test provides all the arguments required by the command, so the
     * command runs non-interactively and it won't ask for any argument.
     */
    public function testCreateUserNonInteractive(): void
    {
        $input = $this->projectData;
        $this->executeCommand($input);

        $this->assertProjectCreated();
    }

    /**
     *
     * This test doesn't provide all the arguments required by the command, so
     * the command runs interactively and it will ask for the value of the missing
     * arguments.
     * See https://symfony.com/doc/current/components/console/helpers/questionhelper.html#testing-a-command-that-expects-input
     */
    public function testCreateUserInteractive(): void
    {
        $this->executeCommand([],
                              array_values($this->projectData)
        );

        $this->assertProjectCreated();
    }

    /**
     * This helper method checks that the user was correctly created and saved
     * in the database.
     */
    private function assertProjectCreated(): void
    {
        $data = [
            'name'      => $this->projectData['name'],
            'amount'    => $this->projectValidator->validateAmount($this->projectData['amount']),
            'startDate' => $this->projectValidator->validateStartDate($this->projectData['start_date']),
        ];

        /** @var \App\Entity\Project\Project $project */
        $project = $this->projectRepository->findOneBy($data);

        $this->assertNotNull($project);
        $this->assertSame($data['name'], $project->getName());
        $this->assertSame($data['amount'], $project->getAmount());
        $this->assertSame(($data['startDate'])->getTimestamp(), $project->getStartDate()->getTimestamp());
    }

}
