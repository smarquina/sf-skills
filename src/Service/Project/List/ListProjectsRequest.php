<?php

namespace App\Service\Project\List;


class ListProjectsRequest {

    public function __construct(
        private int $page = 1
    )
    {
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

}
