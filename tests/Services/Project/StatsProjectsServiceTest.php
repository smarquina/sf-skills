<?php

namespace App\Tests\Services\Project;

use App\Repository\Project\ProjectRepository;
use App\Service\Project\Stats\StatsProjectsService;
use PHPUnit\Framework\TestCase;

class StatsProjectsServiceTest extends TestCase {

    private ProjectRepository    $projectRepository;
    private StatsProjectsService $statsProjectsService;

    private static int $numProjects = 10;
    private static int $totalAmount = 10000;

    public function setUp(): void
    {
        $this->projectRepository    = $this->createMock(ProjectRepository::class);
        $this->statsProjectsService = new StatsProjectsService($this->projectRepository);

        parent::setUp();
    }


    private function mockStats(): void
    {
        $this->projectRepository
            ->expects(self::once())
            ->method('getAllProjectsStats')
            ->willReturn([static::$numProjects, static::$totalAmount]);
    }
    
    public function testStats(): void
    {
        $this->mockStats();

        $response = $this->statsProjectsService->handle();
        $this->assertSame($response->getTotalProjects(), static::$numProjects, "Failed to count projects number");
        $this->assertSame($response->getTotalAmount(), static::$totalAmount, "Failed to count projects amount");
    }
}
