<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\Walk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Walk|null find($id, $lockMode = null, $lockVersion = null)
 * @method Walk|null findOneBy(array $criteria, array $orderBy = null)
 * @method Walk[]    findAll()
 * @method Walk[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Walk::class);
    }

    // /**
    //  * @return Walk[] Returns an array of Walk objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Walk
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    /**
     * Find walk with given visitor as parameter using DQL object
     * @return Walk[] Returns an array of Walk objects
     */
    public function findByVisitors(Account $visitor)
    {
        return $this->createQueryBuilder('walk')
            ->leftJoin('walk.visitors', 'account')
            ->andWhere('account.id = :val')
            ->setParameter('val', $visitor)
            ->orderBy('walk.date', 'DESC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        ;
    }

    /**
     * Find walks with given keywords using DQL object
     * @return Walk[] Returns an array of Walk objects
     */
    public function findByKeywords(string $keywords)
    {
        $qb = $this->createQueryBuilder('walk');

        if($keywords) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('walk.title', ':title'),
                $qb->expr()->like('walk.description', ':description')
            ))
            ->setParameter('title', "%".$keywords."%")
            ->setParameter('description', "%".$keywords."%");
        }

        return $qb->orderBy('walk.date', 'DESC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Find walk with given visitor as parameter using DQL object
     * @return Walk[] Returns an array of Walk objects
     */
    public function getLastThreeWalks()
    {
        return $this->createQueryBuilder('walk')
            ->leftJoin('walk.visitors', 'account')
            ->orderBy('walk.date', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
        ;
    }
}
