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
        Assert\NotBlank(message: 'name.validation.blank'),
        Assert\Length(
            min: 5,
            max: 255,
            minMessage: 'name.validation.too_short',
            maxMessage: 'name.validation.too_long',
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
        Assert\NotBlank(message: 'amount.validation.blank'),
        Assert\Type(type: 'integer'),
        Assert\Length(
            min: 1,
            minMessage: 'amount.validation.minimum',
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
     * @return string
     */
    public function getPrintableAmount(): string
    {
        return sprintf("%.2f €", $this->amount / 100);
    }

    /**
     * @param \DateTime $createdAt
     * @return Project
     */
    public function setCreatedAt(\DateTime $createdAt): Project
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \App\Entity\Project\Project
     */
    public static function fromEmptyProject(): Project
    {
        return (new self())
            ->setName("")
            ->setAmount(0)
            ->setStartDate(new \DateTime());
    }
}
