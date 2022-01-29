<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Utils;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use function Symfony\Component\String\u;

/**
 * This class is used to provide an example of integrating simple classes as
 * services into a Symfony application.
 * See https://symfony.com/doc/current/service_container.html#creating-configuring-services-in-the-container.
 *
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class Validator {
    public function validateName(?string $name): string
    {
        if (empty($name)) {
            throw new InvalidArgumentException('The name can not be empty.');
        }

        if (1 !== preg_match('/^[0-9a-z_]+$/', $name)) {
            throw new InvalidArgumentException('The username must contain only lowercase latin characters and underscores.');
        }

        return $name;
    }

    public function validateAmount(?string $amount): string
    {
        if (empty($amount)) {
            throw new InvalidArgumentException('The amount can not be empty.');
        }

        //TODO: validate

        return $amount;
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
