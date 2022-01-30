<?php

namespace App\Service\Project\Add;

use App\Entity\Project\Project;
use App\Repository\Project\ProjectRepository;

class AddProjectService {

    public function __construct(private ProjectRepository $projectRepository)
    {
    }

    public function handle(AddProjectRequest $request): Project
    {

        $project = new Project();
        $project->setName($request->getName())
                ->setAmount($request->getAmount())
                ->setStartDate($request->getStartDate());

        $this->projectRepository->save($project);

        return $project;
    }
}
