<?php


namespace bookstore\repository;


use bookstore\dto\BookDtoFactory;
use bookstore\exceptions\Exception400;
use bookstore\services\Response;

/**
 * CRUD book objects
 * Class BookRepository
 * @package bookstore\repository
 */
class BookRepository
{
    /**
     * @var BookDataAccess
     */
    protected BookDataAccess $dataAccess;

    /**
     * @var BookDtoFactory
     */
    protected BookDtoFactory $bookFactory;

    /**
     * BookRepository constructor.
     * @param BookDataAccess $dataAccess
     */
    public function __construct(BookDataAccess $dataAccess, BookDtoFactory $bookDtoFactory)
    {
        $this->dataAccess = $dataAccess;
        $this->bookFactory = $bookDtoFactory;
    }

    /**
     * Return an array of BookDto objects
     * Needs max limit on ids passed!
     * @param array $ids
     * @return array
     * @throws Exception400
     */
    public function findBooksByIds(array $ids): array
    {
        $ret = [];
        $books = $this->dataAccess->getBookByIds($ids);
        if (empty($books)) {
            throw new Exception400('No books found', Response::NOTFOUND);
        }

        foreach ($books as $book) {
            $ret[] = $this->bookFactory->create($book);
        }

        return $ret;
    }

    /**
     * Delete multiple books
     * Needs max limit on ids passed!
     * @param array $ids
     * @return bool
     * @throws Exception400
     */
    public function deleteBookById(array $ids)
    {
        $rowCount = $this->dataAccess->deleteById($ids);
        if ($rowCount === 0) {
            throw new Exception400('No records found for deletion', 404);
        }
        return true;
    }
}