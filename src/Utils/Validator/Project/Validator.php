<?php

namespace App\Utils\Validator\Project;

use Symfony\Component\Console\Exception\InvalidArgumentException;


class Validator {
    public function validateName(?string $name): string
    {
        if (empty($name)) {
            throw new InvalidArgumentException('The name can not be empty.');
        }

        if (1 !== preg_match('/^[\w_]+$/', $name)) {
            throw new InvalidArgumentException('The name must contain only latin characters, numbers and underscores.');
        }

        return $name;
    }

    public function validateAmount(?string $amount): int
    {
        if (empty($amount)) {
            throw new InvalidArgumentException('The amount can not be empty.');
        }

        $amountObject = (int)$amount;
        if ($amountObject < 1) {
            throw new InvalidArgumentException('Amount must be bigger than 1.');
        }

        return $amountObject;
    }

    /**
     * @param string|null $startDate
     * @return \DateTime
     */
    public function validateStartDate(?string $startDate): \DateTime
    {
        if (empty($startDate)) {
            throw new InvalidArgumentException('The start date can not be empty.');
        }

        if ($startDateTime = \DateTime::createFromFormat('d-m-Y', $startDate)) {
            return $startDateTime;
        }
        throw new InvalidArgumentException('Date can\'t be parsed');
    }
}
