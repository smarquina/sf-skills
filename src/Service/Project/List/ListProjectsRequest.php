<?php

namespace App\Service\Project\List;


class ListProjectsRequest {

    public function __construct(
        private int $page = 1,
        private ?string $name = null
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

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

}
