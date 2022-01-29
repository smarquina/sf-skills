<?php

namespace App\Service\Project;

class AddProjectRequest {

    public function __construct(
        private string $name,
        private int $amount,
        private \DateTime $startDate
    ){
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }
}
