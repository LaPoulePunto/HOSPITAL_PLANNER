<?php

namespace App\Repository;

use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Patient>
 *
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    public function findByIdPastOrFuturReservation(int $id, bool $isFuture)
    {
        $todayDate = new \DateTime();
        $query = $this->createQueryBuilder('p')
            ->innerJoin('p.consultation', 'c')
            ->addSelect('c')
            ->where('p.id = :id');
        // Si time vaut true, alors on récupère les consultations futures
            if($isFuture){
                $query->andWhere('c.date >= :todayDate');
            }
        // Sinon, on récupère les passées
            else{
                $query->andWhere('c.date < :todayDate');
            }
            return $query->setParameter('id', $id)
            ->setParameter('todayDate', $todayDate)
            ->orderBy('c.date', 'ASC')
            ->getQuery()
            ->getResult();
    }


    //    /**
    //     * @return Patient[] Returns an array of Patient objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Patient
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
