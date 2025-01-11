<?php

namespace App\Repository;

use App\Entity\Consultation;
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

    public function getAllActiveHealthProfessional()
    {
        return $this->createQueryBuilder('hp')
            ->where('hp.departureDate IS NULL')
            ->getQuery()
            ->getResult();
    }

    public function getAllHealthProfessionalPossible(Consultation $consultation): array
    {
        return $this->createQueryBuilder('hp')
            ->innerJoin('hp.speciality', 's')
            ->innerJoin('s.consultationTypes', 'ct')
            ->innerJoin('ct.consultation', 'c')
            ->innerJoin('hp.availability', 'a')
            ->select('hp, s, ct, a')
            ->where('c.id = :consultationId')
            ->andWhere('a.date = :date')
            ->andWhere('a.startTime <= :startTime')
            ->andWhere('a.endTime >= :endTime')
            ->setParameter('consultationId', $consultation->getId())
            ->setParameter('date', $consultation->getDate()->format('Y-m-d'))
            ->setParameter('startTime', $consultation->getStartTime()->format('H:i:s'))
            ->setParameter('endTime', $consultation->getEndTime()->format('H:i:s'))
            ->getQuery()
            ->getResult();
    }
}
