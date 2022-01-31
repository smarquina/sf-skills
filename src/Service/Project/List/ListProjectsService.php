<?php

namespace App\Service\Project\List;

use App\Pagination\Paginator;
use App\Repository\Project\ProjectRepository;

class ListProjectsService {

    public function __construct(private ProjectRepository $projectRepository)
    {
    }

    public function handle(ListProjectsRequest $request): Paginator
    {
        return $this->projectRepository->findAll($request->getPage());
    }

}
