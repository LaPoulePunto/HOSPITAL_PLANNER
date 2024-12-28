<?php

namespace App\Repository;

use App\Entity\AvailabilitySplitSlots;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AvailabilitySplitSlots>
 *
 * @method AvailabilitySplitSlots|null find($id, $lockMode = null, $lockVersion = null)
 * @method AvailabilitySplitSlots|null findOneBy(array $criteria, array $orderBy = null)
 * @method AvailabilitySplitSlots[]    findAll()
 * @method AvailabilitySplitSlots[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvailabilitySplitSlotsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvailabilitySplitSlots::class);
    }

    //    /**
    //     * @return AvailabilitySplitSlots[] Returns an array of AvailabilitySplitSlots objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AvailabilitySplitSlots
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
