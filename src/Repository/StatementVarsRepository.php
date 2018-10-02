<?php

namespace App\Repository;

use App\Entity\StatementVars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StatementVars|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatementVars|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatementVars[]    findAll()
 * @method StatementVars[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatementVarsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StatementVars::class);
    }

    public function findInTipValues($names_array)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.name IN (:name)')
            ->setParameter('name', $names_array)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return StatementVars[] Returns an array of StatementVars objects
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
    public function findOneBySomeField($value): ?StatementVars
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
