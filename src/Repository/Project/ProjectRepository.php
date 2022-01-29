<?php

namespace App\Repository\Project;

use App\Entity\Project\Project;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class ProjectRepository extends ServiceEntityRepository {

    public function __construct(
        ManagerRegistry                $registry,
        private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Project::class);
    }

    public function findByName(string $name, int $limit = Paginator::PAGE_SIZE): array
    {
        return $this->createQueryBuilder('project')
                    ->where('p.name LIKE :term')
                    ->setParameter('term', '%' . $name . '%')
                    ->orderBy('p.createdAt', 'DESC')
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->getResult();
    }

    public function save(Project $project, bool $flush = true): void
    {
        $this->entityManager->persist($project);

        if ($flush) {
            $this->entityManager->flush();
        }
    }
}
