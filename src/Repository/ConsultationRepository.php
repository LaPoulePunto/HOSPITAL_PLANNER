<?php

namespace App\Repository;

use App\Entity\Consultation;
use App\Entity\Patient;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consultation>
 *
 * @method Consultation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultation[]    findAll()
 * @method Consultation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultation::class);
    }

    public function getConsultationById(int $consultationId): ?Consultation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :consultationID')
            ->setParameter('consultationID', $consultationId)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getAllConsultationsByUser(User $user): array
    {
        $qb = $this->createQueryBuilder('c')
            ->innerJoin('c.healthProfessional', 'hp')
            ->innerJoin('c.patient', 'p')
            ->innerJoin('c.consultationType', 'ct')
            ->innerJoin('c.room', 'r')
            ->innerJoin('r.roomType', 'rt')
            ->addSelect('hp', 'p', 'ct', 'r', 'rt')
            ->orderBy('c.date', 'DESC');

        if (in_array('ROLE_HEALTH_PROFESSIONAL', $user->getRoles())) {
            $qb->where('hp.id = :id');
        }
        if (in_array('ROLE_PATIENT', $user->getRoles())) {
            $qb->where('p.id = :id');
        }

        return $qb->setParameter('id', $user->getId())
            ->getQuery()
            ->getResult();
    }

    public function findConsultationByPatientPastOrFuturReservation(User $user, bool $isFuture)
    {
        $todayDate = new \DateTime();
        $query = $this->createQueryBuilder('c')
            ->leftJoin('c.healthProfessional', 'hp')
            ->leftJoin('c.patient', 'p')
            ->addSelect('hp')
            ->addSelect('c');

        // Health Professional ou patient
        if (in_array('ROLE_HEALTH_PROFESSIONAL', $user->getRoles())) {
            $query->where('hp.id = :id');
        }
        if (in_array('ROLE_PATIENT', $user->getRoles())) {
            $query->where('p.id = :id');
        }

        // Passé ou futur
        if ($isFuture) {
            $query->andWhere('c.date >= :todayDate');
        } else {
            $query->andWhere('c.date < :todayDate');
        }

        return $query->setParameter('id', $user)
            ->setParameter('todayDate', $todayDate)
            ->orderBy('c.date', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
