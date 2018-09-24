<?php

namespace App\Repository;

use App\Entity\Statements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Statements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Statements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Statements[]    findAll()
 * @method Statements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatementsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Statements::class);
    }

//    /**
//     * @return Statements[] Returns an array of Statements objects
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
    public function findOneBySomeField($value): ?Statements
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
