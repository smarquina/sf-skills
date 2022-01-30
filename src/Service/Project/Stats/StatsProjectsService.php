<?php

namespace App\Service\Project\Stats;

use App\Repository\Project\ProjectRepository;

class StatsProjectsService {

    public function __construct(private ProjectRepository $projectRepository)
    {
    }

    public function handle(): StatsProjectResponse
    {
        [$total, $amount] = array_values($this->projectRepository
                                             ->getAllProjectsStats());

        return new StatsProjectResponse($total, $amount);
    }
}
