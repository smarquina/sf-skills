<?php

namespace App\Tests\Services\Project;

use App\Entity\Project\Project;
use App\Repository\Project\ProjectRepository;
use App\Service\Project\Add\AddProjectRequest;
use App\Service\Project\Add\AddProjectService;
use App\Tests\DatabaseTestCase;
use App\Tests\Factory\Project\ProjectFactory;

class AddProjectServiceTest extends DatabaseTestCase {

    private ProjectRepository $projectRepository;
    private AddProjectService $addProjectService;

    public function setUp(): void
    {
        $this->projectRepository = $this->createMock(ProjectRepository::class);
        $this->addProjectService = new AddProjectService($this->projectRepository);

        parent::setUp();
    }


    private function mockProject(Project $project): void
    {
        $this->projectRepository
            ->expects(self::once())
            ->method('save');
    }

    /**
     * @dataProvider postDataProvider
     */
    public function testAddProject(ProjectFactory $factory): void
    {
        /** @var Project $project */
        $project = $factory->withoutPersisting()->create()->object();
        $this->mockProject($project);

        $responseProject = $this->addProjectService->handle(
            new AddProjectRequest($project->getName(), $project->getAmount(), $project->getStartDate())
        );

        $this->assertSame($responseProject->getName(), $project->getName(), "Failed to add project");
        $this->assertSame($responseProject->getAmount(), $project->getAmount(), "Failed to add project");
    }

    private static function postDataProvider(): iterable
    {
        yield [ProjectFactory::new()];
    }
}
