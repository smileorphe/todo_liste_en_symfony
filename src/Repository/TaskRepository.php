<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function save(Task $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Task $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Trouve toutes les tâches d'un utilisateur avec filtres optionnels
     */
    public function findByUserWithFilters(
        User $user,
        ?bool $isCompleted = null,
        ?string $priority = null,
        ?string $sortBy = 'createdAt',
        ?string $sortDirection = 'DESC',
        ?int $limit = null,
        ?int $offset = null
    ): array {
        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.user = :user')
            ->setParameter('user', $user);

        // Filtre par statut de complétion
        if ($isCompleted !== null) {
            $qb->andWhere('t.isCompleted = :isCompleted')
                ->setParameter('isCompleted', $isCompleted);
        }

        // Filtre par priorité
        if ($priority !== null) {
            $qb->andWhere('t.priority = :priority')
                ->setParameter('priority', $priority);
        }

        // Filtre par date d'échéance (tâches à venir)
        if ($sortBy === 'dueDate') {
            $qb->andWhere('t.dueDate IS NOT NULL');
        }

        // Tri
        switch ($sortBy) {
            case 'title':
                $qb->orderBy('t.title', $sortDirection);
                break;
            case 'dueDate':
                $qb->orderBy('t.dueDate', $sortDirection);
                break;
            case 'priority':
                $qb->orderBy('t.priority', $sortDirection);
                break;
            case 'createdAt':
            default:
                $qb->orderBy('t.createdAt', $sortDirection);
                break;
        }

        // Pagination
        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }
        
        if ($offset !== null) {
            $qb->setFirstResult($offset);
        }

        return $qb->getQuery()->getResult();
    }
}
