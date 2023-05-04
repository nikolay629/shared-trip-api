<?php

namespace App\Repository;

use App\Entity\ConfirmTrip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConfirmTrip>
 *
 * @method ConfirmTrip|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfirmTrip|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfirmTrip[]    findAll()
 * @method ConfirmTrip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfirmTripRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfirmTrip::class);
    }

    /**
     * @param ConfirmTrip $entity
     * @param bool        $flush
     *
     * @return void
     */
    public function save(ConfirmTrip $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param ConfirmTrip $entity
     * @param bool        $flush
     *
     * @return void
     */
    public function remove(ConfirmTrip $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConfirmTrip[] Returns an array of ConfirmTrip objects
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

//    public function findOneBySomeField($value): ?ConfirmTrip
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
