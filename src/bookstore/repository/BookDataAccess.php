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
     * Fetch list of books by ids
     * @param array $ids
     * @return array
     * @throws Exception400
     */
    public function getBookByIds(array $ids): array
    {
        $in = str_repeat('?,', count($ids) - 1) . '?';
        $sql = 'SELECT b.id, a.name as author, b.title, b.isbn, b.release_date'.
            ' FROM books b LEFT JOIN' .
            ' authors a ON b.author_id=a.id where b.id IN (' . $in . ')';

        $stm = $this->connection->prepare($sql);
        $stm->execute($ids);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        $query = 'DELETE FROM books WHERE id =: id';
        $prep = $this->connection->prepare($query);
        if ($prep) {
            $prep->execute(['id' => $id]);
        }
        return true;
    }


}