<?php

namespace App\Repository;

use App\Entity\Library;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Library>
 */
class LibraryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Library::class);
    }

    /**
     * Find book ID based on given ISBN.
     *
     * @return array<array> Returns an array of arrays (i.e. a raw data set)
     */
    public function findIdByIsbn(string $isbn): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM library AS l
            WHERE l.isbn = :isbn
        ';

        $resultSet = $conn->executeQuery($sql, ['isbn' => $isbn]);

        return $resultSet->fetchAllAssociative();
    }
}
