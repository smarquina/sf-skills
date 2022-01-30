<?php

namespace App\Service\Project\Stats;

class StatsProjectResponse {

    public function __construct(
        private int $totalProjects,
        private int $totalAmount
    )
    {

    }

    /**
     * @return int
     */
    public function getTotalProjects(): int
    {
        return $this->totalProjects;
    }

    /**
     * @return int
     */
    public function getTotalAmount(): int
    {
        return $this->totalAmount;
    }

    /**
     * @return int
     */
    public function getPrintableTotalAmount(): int
    {
        return $this->totalAmount / 100;
    }
}
