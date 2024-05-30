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
     * Find user based on given username.
     *
     * @return array<mixed> Returns an array of arrays (i.e. a raw data set)
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
}
