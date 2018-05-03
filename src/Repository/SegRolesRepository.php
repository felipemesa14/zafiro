<?php

namespace App\Repository;

use App\Entity\SegRoles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SegRoles|null find($id, $lockMode = null, $lockVersion = null)
 * @method SegRoles|null findOneBy(array $criteria, array $orderBy = null)
 * @method SegRoles[]    findAll()
 * @method SegRoles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SegRolesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SegRoles::class);
    }

//    /**
//     * @return SegRoles[] Returns an array of SegRoles objects
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
    public function findOneBySomeField($value): ?SegRoles
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
