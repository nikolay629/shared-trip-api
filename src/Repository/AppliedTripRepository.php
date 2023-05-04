<?php

namespace App\Repository;

use App\Entity\AppliedTrip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppliedTrip>
 *
 * @method AppliedTrip|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppliedTrip|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppliedTrip[]    findAll()
 * @method AppliedTrip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppliedTripRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppliedTrip::class);
    }

    /**
     * @param AppliedTrip $entity
     * @param bool        $flush
     *
     * @return void
     */
    public function save(AppliedTrip $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param AppliedTrip $entity
     * @param bool        $flush
     *
     * @return void
     */
    public function remove(AppliedTrip $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AppliedTrip[] Returns an array of AppliedTrip objects
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

//    public function findOneBySomeField($value): ?AppliedTrip
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
