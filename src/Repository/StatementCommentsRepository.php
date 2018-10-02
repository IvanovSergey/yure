<?php

namespace App\Repository;

use App\Entity\StatementComments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StatementComments|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatementComments|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatementComments[]    findAll()
 * @method StatementComments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatementCommentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StatementComments::class);
    }

//    /**
//     * @return StatementComments[] Returns an array of StatementComments objects
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
    public function findOneBySomeField($value): ?StatementComments
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
