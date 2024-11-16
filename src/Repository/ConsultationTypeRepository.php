<?php

namespace App\Repository;

use App\Entity\ConsultationType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConsultationType>
 *
 * @method ConsultationType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConsultationType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConsultationType[]    findAll()
 * @method ConsultationType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultationTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConsultationType::class);
    }

    //    /**
    //     * @return ConsultationType[] Returns an array of ConsultationType objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ConsultationType
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
