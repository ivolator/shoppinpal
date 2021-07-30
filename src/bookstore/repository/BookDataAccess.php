<?php


namespace bookstore\repository;


use bookstore\exceptions\Exception400;
use bookstore\exceptions\Exception500;
use bookstore\services\Response;
use PDO;
use PDOException;
use Throwable;

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
     * @param array $book
     * @return array
     * @throws Exception500
     */
    public function createBook(array $book): array
    {
        //return the record if exists
        $books = $this->getBookByIsbns([$book['isbn'] ?? null]);
        if (count($books) > 0) {
            return $books;
        }

        $author_id = $this->createAuthor($book['author'] ?? '');

        $args[] = $author_id ?? null;
        $args[] = $book['title'] ?? null;
        $args[] = $book['releaseDate'] ?? null;
        $args[] = $book['isbn'] ?? null;

        try {
            $sqlInsertBook = 'INSERT INTO books (author_id, title, release_date, isbn ) VALUES (?,?,?,?)';
            $ret = $this->getConnection()->prepare($sqlInsertBook)->execute($args);

            if ($ret) { // return record if created
                $books = $this->getBookByIsbns([$book['isbn'] ?? null]);
                if (count($books) > 0) {
                    return $books[0];
                }
            }
        } catch (Throwable $t) {
            throw new Exception500('The book was not created', Response::INTERNALSERVERERROR);
        }
        return [];
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
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
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
        return $this->getAuthorId($author);
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
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
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

    /**
     * @param $id
     * @param $bookDto
     * @return bool
     */
    public function updateBook($id, $bookDto): bool
    {
        if (empty($id) || empty($bookDto)) {
            return false;
        }
        if ($bookDto[$id] ?? null) { //make sure we don't update the id
            unset($bookDto['id']);
        }

        // cook up the args
        $prepArray = array_combine(array_keys($bookDto), array_keys($bookDto));
        if ($prepArray['author'] ?? false) {
            $prepArray['authors.name'] = 'author';
            unset($prepArray['author']);
        }
        if ($prepArray['releaseDate'] ?? false) {
            $prepArray['release_date'] = 'releaseDate';
            unset($prepArray['releaseDate']);
        }
        $setSql = '';
        foreach ($prepArray as $k => $v) {
            $setSql .= $k . '=:' . $v . ',';
        }
        $setSql = rtrim($setSql, ',');
        $bookDto['id'] = $id;

        $sql = 'UPDATE books LEFT JOIN authors ON books.author_id = authors.id ';
        if (empty($prepArray['authors.name'])) { //no join if author is not passed
            $sql = 'UPDATE books ';
        }
        $sql .= 'SET ' . $setSql;
        $sql .= ' WHERE books.id=:id';
        $stm = $this->connection->prepare($sql);
        if (!empty($stm)) {
            $stm->execute($bookDto);
            return (bool)$stm->rowCount();
        }
        return false;
    }
}