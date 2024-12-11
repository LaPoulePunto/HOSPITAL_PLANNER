<?php

namespace App\Repository;

use App\Entity\Consultation;
use App\Entity\Patient;
use App\Entity\HealthProfessional;
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

    public function getAllConsultationsByHealthProfessional(HealthProfessional $healthProfessional)
    {
        $id = $healthProfessional->getId();
        return $this->createQueryBuilder('c')
            ->innerJoin('c.healthProfessional', 'hp')
            ->innerJoin('c.patient', 'p')
            ->innerJoin('c.consultationType', 'ct')
            ->innerJoin('c.room', 'r')
            ->innerJoin('r.roomType', 'rt')
            ->addSelect('hp', 'p', 'ct', 'r', 'rt')
            ->where('hp.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findByPatientPastOrFuturReservation(Patient $patient, bool $isFuture)
    {
        $todayDate = new \DateTime();
        $query = $this->createQueryBuilder('c')
            ->addSelect('c')
            ->where('c.patient = :id');
        // Si time vaut true, alors on récupère les consultations futures
        if ($isFuture) {
            $query->andWhere('c.date >= :todayDate');
        }
        // Sinon, on récupère les passées
        else {
            $query->andWhere('c.date < :todayDate');
        }

        return $query->setParameter('id', $patient)
            ->setParameter('todayDate', $todayDate)
            ->orderBy('c.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return ConsultationFixtures[] Returns an array of ConsultationFixtures objects
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

    //    public function findOneBySomeField($value): ?ConsultationFixtures
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
