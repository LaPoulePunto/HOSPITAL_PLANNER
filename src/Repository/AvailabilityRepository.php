<?php

namespace App\Repository;

use App\Entity\Availability;
use App\Entity\HealthProfessional;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Availability>
 *
 * @method Availability|null find($id, $lockMode = null, $lockVersion = null)
 * @method Availability|null findOneBy(array $criteria, array $orderBy = null)
 * @method Availability[]    findAll()
 * @method Availability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Availability::class);
    }

    public function getRecurringAvailabilitiesByHealthProfessional(HealthProfessional $hp)
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.availabilitySplitSlots', 'slots')
            ->addSelect('slots')
            ->Where('a.healthprofessional = :hp')
            ->andWhere('a.isRecurring = true')
            ->setParameter('hp', $hp)
            ->orderBy('a.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getFuturNoneRecurringAvailabilitiesByHealthProfessional(HealthProfessional $hp)
    {
        $today = new \DateTime();
        return $this->createQueryBuilder('a')
            ->innerJoin('a.availabilitySplitSlots', 'slots')
            ->addSelect('slots')
            ->Where('a.healthprofessional = :hp')
            ->andWhere('a.isRecurring = false')
            ->andWhere('a.date >= :today')
            ->setParameter('hp', $hp)
            ->setParameter('today', $today)
            ->orderBy('a.date', 'ASC')
            ->addOrderBy('a.startTime', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Availability[] Returns an array of Availability objects
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

    //    public function findOneBySomeField($value): ?Availability
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
