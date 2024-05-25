<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Find user ID based on given username.
     *
     * @return array<array> Returns an array of arrays (i.e. a raw data set)
     */
    public function findUserByUsername(string $username): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM user AS u
            WHERE u.username = :username
        ';

        $resultSet = $conn->executeQuery($sql, ['username' => $username]);

        return $resultSet->fetchAllAssociative();
    }

    /**
     * Find user account based on given username.
     *
     * @return array<array> Returns an array of arrays (i.e. a raw data set)
     */
    public function findAccountByUsername(string $username): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT account FROM user AS u
            WHERE u.username = :username
        ';

        $resultSet = $conn->executeQuery($sql, ['username' => $username]);

        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    // public function findOneBySomeField($value): ?User
    // {
    //     return $this->createQueryBuilder('u')
    //         ->andWhere('u.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
}
