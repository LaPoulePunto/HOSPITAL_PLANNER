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

    public function getAllActiveHealthProfessional()
    {
        return $this->createQueryBuilder('hp')
            ->where('hp.departureDate IS NULL')
            ->getQuery()
            ->getResult();
    }

    public function getAllHealthProfessionalPossible(int $consultationId): array
    {
        return $this->createQueryBuilder('hp')
            ->innerJoin('hp.speciality', 's')
            ->innerJoin('s.consultationTypes', 'ct')
            ->innerJoin('ct.consultation', 'c')
            ->select('hp, s, ct')
            ->where('c.id = :consultationId')
            ->setParameter('consultationId', $consultationId)
            ->getQuery()
            ->getResult();

    }
}
