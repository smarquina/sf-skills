<?php

namespace App\Tests\Command\Project;

use App\Repository\Project\ProjectRepository;
use App\Service\Project\Stats\StatsProjectsService;
use App\Tests\DatabaseTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class StatsProjectsCommandTest extends DatabaseTestCase {

    use ResetDatabase, Factories;

    private ProjectRepository    $projectRepository;
    private StatsProjectsService $statsProjectsService;

    private static int $totalProjects = 10;
    private static int $totalAmount   = 100000;

    public function setUp(): void
    {
        $this->projectRepository    = $this->createMock(ProjectRepository::class);
        $this->statsProjectsService = new StatsProjectsService($this->projectRepository);

        parent::setUp();
    }


    private function getMock(): void
    {
        $this->projectRepository
            ->expects(self::once())
            ->method('getAllProjectsStats')
            ->willReturn([static::$totalProjects, static::$totalAmount]);
    }

    public function testAddProject(): void
    {
        $this->getMock();
        $responseStats = $this->statsProjectsService->handle();

        $this->assertSame($responseStats->getTotalProjects(),
                          static::$totalProjects,
                          "Failed to count projects");
        $this->assertSame($responseStats->getTotalAmount(),
                          static::$totalAmount,
                          "Failed to sum project amounts");
    }
}
