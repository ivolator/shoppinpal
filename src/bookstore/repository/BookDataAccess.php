<?php


namespace bookstore\repository;


use bookstore\exceptions\Exception400;
use PDO;

class BookDataAccess
{
    /**
     * @var PDO
     */
    protected PDO $connection;

    /**
     * BookDataAccess constructor.
     * @param PDO $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection->getConnection();
    }

    /**
     * Not sure if this is required
     * Fetch list of books by  ISBN
     * Returnns an associative array of arrays
     * @param array $isbns
     * @return array
     */
    public function getBookByIsbns(array $isbns): array
    {
        $in = str_repeat('?,', count($isbns) - 1) . '?';
        $sql = 'SELECT b.id, a.name as author, b.title, b.isbn, b.release_date as releaseDate' .
            ' FROM books b LEFT JOIN' .
            ' authors a ON b.author_id=a.id where b.isbn IN (' . $in . ')';

        $stm = $this->connection->prepare($sql);
        if (!empty($stm)) {
            $stm->execute($isbns);
        }
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch list of books by ids
     * Returnns an associative array of arrays
     * @param array $ids
     * @return array
     */
    public function getBookByIds(array $ids): array
    {
        if (count($ids) == 0) {
            return [];
        }
        $in = str_repeat('?,', count($ids) - 1) . '?';
        $sql = 'SELECT b.id, a.name as author, b.title, b.isbn, b.release_date as releaseDate' .
            ' FROM books b LEFT JOIN' .
            ' authors a ON b.author_id=a.id where b.id IN (' . $in . ')';

        $stm = $this->connection->prepare($sql);
        if (!empty($stm)) {
            $stm->execute($ids);
        }
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     * @return int
     * @throws Exception400
     */
    public function deleteById(array $ids): int
    {
        if (count($ids) == 0) {
            return 0;
        }
        $in = str_repeat('?,', count($ids) - 1) . '?';
        $query = 'DELETE FROM books WHERE id in (' . $in . ')';
        $stm = $this->connection->prepare($query);
        if (!empty($stm)) {
            $stm->execute($ids);
           return $stm->rowCount();
        }

        return 0;
    }

}