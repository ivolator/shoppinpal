<?php

namespace bookstore\repository;

use bookstore\exceptions\Exception400;
use bookstore\exceptions\Exception500;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class BookDataAccessTest extends TestCase
{
    protected $pdoStatement;
    protected $pdo;
    protected $connection;

    public function setUp(): void
    {
        $this->pdoStatement = $this->getMockBuilder(PDOStatement::class)->disableOriginalConstructor()->getMock();
        $this->pdo = $this->getMockBuilder(PDO::class)->disableOriginalConstructor()->getMock();

        $this->connection = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $this->connection->expects(self::any())->method('getConnection')->willReturn($this->pdo);
    }

    /**
     * Confirm it falls through the first check
     * @throws Exception500
     */
    public function testCreateBookExists()
    {
        $ret = [1, 'name', 'isbn', 'title'];
        $bookDataAccess = $this->getMockBuilder(BookDataAccess::class)->disableOriginalConstructor()->getMock();
        $bookDataAccess->method('getBookByIsbns')->willReturn($ret);
        $bookDataAccess->expects(self::never())->method('getBookByIsbns');
        $bookDataAccess->createBook(['somedata']);
    }

    /**
     * SELECT SQL executed with correct prepared statement
     */
    public function testGetBookByIds()
    {
        $sql = 'SELECT b.id, a.name as author, b.title, b.isbn, b.release_date as releaseDate' .
            ' FROM books b LEFT JOIN' .
            ' authors a ON b.author_id=a.id where b.id IN (?,?)';

        $this->pdo->expects(self::once())->method('prepare')->with($sql)->willReturn($this->pdoStatement);
        $this->pdoStatement->expects(self::once())->method('execute');
        $this->pdoStatement->expects(self::once())->method('fetchAll')->willReturn(['some', 'records']);

        $da = new BookDataAccess($this->connection);
        $da->getBookByIds([1, 2]);
    }

    /**
     * No ids were passed
     */
    public function testGetByByIdNoArgs()
    {
        $da = new BookDataAccess($this->connection);
        $this->assertEmpty($da->getBookByIds([]));
    }

    /**
     * DELETE SQL executed with correct prepared statement
     */
    public function testDeleteById()
    {
        $sql = 'DELETE FROM books WHERE id in (?,?)';

        $this->pdo->expects(self::once())->method('prepare')->with($sql)->willReturn($this->pdoStatement);
        $this->pdoStatement->expects(self::once())->method('execute');
        $this->pdoStatement->expects(self::once())->method('rowCount')->willReturn(1);

        $da = new BookDataAccess($this->connection);
        $da->deleteById([1, 2]);
    }

    /**
     * No ids were passed
     * @throws Exception400
     */
    public function testDeleteByIdNoArgs()
    {
        $da = new BookDataAccess($this->connection);
        $this->assertEmpty($da->deleteById([]));
    }
}
