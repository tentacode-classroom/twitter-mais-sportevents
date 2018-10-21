<?php

namespace App\Repository;

use App\Entity\Friend;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Friend|null find($id, $lockMode = null, $lockVersion = null)
 * @method Friend|null findOneBy(array $criteria, array $orderBy = null)
 * @method Friend[]    findAll()
 * @method Friend[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FriendRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Friend::class);
    }

    public function findFollowers($user): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.following = :val')
            ->setParameter('val', $user->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function findFollowings($user): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.follower = :val')
            ->setParameter('val', $user->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function findFriendby($user, $loggedUser): ?Friend
    {
        return $this->createQueryBuilder('f')
        ->andWhere('f.follower = :val')
        ->setParameter('val',$loggedUser->getId())
        ->andWhere('f.following = :us')
        ->setParameter('us', $user->getId())
        ->getQuery()
        ->getOneOrNullResult();
    }

//    /**
//     * @return Friend[] Returns an array of Friend objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Friend
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}