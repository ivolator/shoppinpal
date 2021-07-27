<?php


namespace bookstore\repository;


use bookstore\exceptions\Exception400;
use PDO;
use PDOException;

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
     * Create books from assoc array of arrays
     * @param array $book
     * @return bool
     */
    public function createBook(array $book): bool
    {
        $author_id = $this->createAuthor($book['author']);

        $args[] = $author_id ?? null;
        $args[] = $book['title'] ?? null;
        $args[] = $book['releaseDate'] ?? null;
        $args[] = $book['isbn'] ?? null;

        $sqlInsertBook = 'INSERT INTO books (author_id, title, isbn, release_date)' .
            'VALUES (?,?,?,?)';
        $this->connection->prepare($sqlInsertBook)->execute($args);
        return true;
    }

    /**
     * @param string $author
     * @return array
     */
    public function createAuthor(string $author): int
    {
        $sqlInsertBook = 'INSERT INTO authors (name) VALUES (?)';
        try {
            $this->connection->prepare($sqlInsertBook)->execute([$author]);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] != 1062) {
                throw $e;//some other error
            }
        }
        return $this->getAuthorId($author);;
    }

    /**
     * @param string $authorName
     * @return mixed
     */
    protected function getAuthorId(string $authorName)
    {
        $sqlSelect = 'SELECT id FROM authors WHERE name = ?';
        $stm = $this->connection->prepare($sqlSelect);
        if (!empty($stm)) {
            $stm->execute([$authorName]);
        }
        return $stm->fetchColumn();
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