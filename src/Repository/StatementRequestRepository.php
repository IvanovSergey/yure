<?php

namespace App\Repository;

use App\Entity\StatementRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StatementRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatementRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatementRequest[]    findAll()
 * @method StatementRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatementRequestRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StatementRequest::class);
    }

//    /**
//     * @return StatementRequest[] Returns an array of StatementRequest objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatementRequest
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
