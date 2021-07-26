<?php

namespace bookstore\repository;

use bookstore\exceptions\Exception400;
use PHPUnit\Framework\TestCase;

class BookRepositoryTest extends TestCase
{
    /**
     * @var BookDataAccess
     */
    protected BookDataAccess $bookDataAccess;

    /**
     * Test happy path
     * @throws Exception400
     */
    public function testFindBooksByIdHappyPath()
    {
        $listOfBooks = [
            ['id' => 3, 'author' => 'AuthorNameIsSet', 'title' => 'TitleIsSet', 'isbn' => 'ISBNisSet', 'releaseDate' => '2020-01-01']
        ];

        $this->bookDataAccess->method('getBookByIds')->willReturn($listOfBooks);

        $bookRepo = new BookRepository($this->bookDataAccess);
        $res = $bookRepo->findBooksByIds([1]);
        $this->assertInstanceOf('\\bookstore\\dto\\BookDto', $res[0]);
    }

    /**
     * Test No books found exception Exception400
     * @throws Exception400
     */
    public function testNoBooksFoundException()
    {
        $this->bookDataAccess->method('getBookByIds')->willReturn([]);

        $bookRepo = new BookRepository($this->bookDataAccess);
        try {
            $bookRepo->findBooksByIds([1]);
        } catch (\Exception $e) {
            $this->assertInstanceOf('\\bookstore\\exceptions\\Exception400', $e);
            $this->assertSame('No books found', $e->getMessage());
        }
    }

    /**
     * Return true upon successful deletion
     * @throws Exception400
     */
    public function testDeleteBookByIdReturnsTrue()
    {
        $this->bookDataAccess->method('deleteById')->willReturn(4);
        $bookRepo = new BookRepository($this->bookDataAccess);
        $this->assertEquals(true, $bookRepo->deleteBookById([1, 2, 3]));
    }

    /**
     * Throws 404 when no books found upon successful deletion
     * @throws Exception400
     */
    public function testDeleteBookByIdThrows()
    {
        try {
            //no records deleted
            $this->bookDataAccess->method('deleteById')->willReturn(0);
            $bookRepo = new BookRepository($this->bookDataAccess);
            $bookRepo->deleteBookById([1, 2, 3]);
        } catch (Exception400 $e) {
            $this->assertSame(404, $e->getCode());
            $this->assertSame('No records found for deletion', $e->getMessage());
        }

    }

    /**
     * Setup data access
     */
    protected function setUp(): void
    {
        $this->bookDataAccess = $this->getMockBuilder(BookDataAccess::class)->disableOriginalConstructor()->getMock();
    }


}
