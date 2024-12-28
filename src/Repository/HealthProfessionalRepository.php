<?php

namespace App\Repository;

use App\Entity\HealthProfessional;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HealthProfessional>
 *
 * @method HealthProfessional|null find($id, $lockMode = null, $lockVersion = null)
 * @method HealthProfessional|null findOneBy(array $criteria, array $orderBy = null)
 * @method HealthProfessional[]    findAll()
 * @method HealthProfessional[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HealthProfessionalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HealthProfessional::class);
    }


    //    /**
    //     * @return HealthProfessionnal[] Returns an array of HealthProfessionnal objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?HealthProfessionnal
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
