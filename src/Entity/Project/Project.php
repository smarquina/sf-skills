<?php

declare(strict_types=1);

namespace App\Entity\Project;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="projects")
 */
class Project {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="text")
     */
    #[
        Assert\NotBlank(message: 'name.blank'),
        Assert\Length(
            min: 5,
            max: 10000,
            minMessage: 'name.too_short',
            maxMessage: 'name.too_long',
        )
    ]
    private string $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $startDate;

    /**
     * Save this value as int. Do not save as decimal on DB
     * @ORM\Column(type="bigint")
     */
    #[
        Assert\NotBlank(message: 'amount.blank'),
        Assert\Length(
            min: 1,
            minMessage: 'amount.minimum',
        )
    ]
    private int $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Project
     */
    public function setName(string $name): Project
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     * @return Project
     */
    public function setStartDate(\DateTime $startDate): Project
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return Project
     */
    public function setAmount(int $amount): Project
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
