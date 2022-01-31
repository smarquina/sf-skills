<?php

namespace App\Repository\Project;

use App\Entity\Project\Project;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

class ProjectRepository extends ServiceEntityRepository {

    public function __construct(
        ManagerRegistry                $registry,
        private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * @param string   $name
     * @param int      $limit
     * @param int|null $page
     * @return Paginator|ArrayCollection
     */
    public function findByName(string $name,
                               int    $limit = Paginator::PAGE_SIZE,
                               ?int   $page = null): Paginator|ArrayCollection
    {
        $qb = $this->createQueryBuilder('project')
                   ->where('project.name LIKE :term')
                   ->setParameter('term', '%' . $name . '%')
                   ->orderBy('project.startDate', 'DESC');

        return $page > 0
            ? (new Paginator($qb))->paginate($page)
            : new ArrayCollection($qb->getQuery()
                                     ->setMaxResults($limit)
                                     ->getResult());
    }

    /**
     * @param int|null $page
     * @return Paginator|ArrayCollection
     */
    public function findAll(?int $page = null): Paginator|ArrayCollection
    {
        $qb = $this->createQueryBuilder('project')
                   ->orderBy('project.startDate', 'DESC');

        return $page > 0
            ? (new Paginator($qb))->paginate($page)
            : new ArrayCollection($qb->getQuery()->getResult());

    }

    /**
     * @return int[]
     */
    public function getAllProjectsStats(): array
    {
        try {
            return $this->createQueryBuilder('project')
                        ->select('count(project.id), sum(project.amount)')
                        ->getQuery()
                        ->getSingleResult();
        } catch (NoResultException|NonUniqueResultException) {
            return [0, 0];
        }
    }

    public function save(Project $project, bool $flush = true): void
    {
        $this->entityManager->persist($project);

        if ($flush) {
            $this->entityManager->flush();
        }
    }
}
