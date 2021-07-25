<?php


namespace bookstore\repository;


use bookstore\dto\BookDtoFactory;

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
     * BookRepository constructor.
     * @param BookDataAccess $dataAccess
     */
    public function __construct(BookDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    /**
     * @throws \bookstore\exceptions\Exception400
     */
    public function findBooksByIds(array $ids): array
    {
        $ret = [];
        $books = $this->dataAccess->getBookByIds($ids);
        foreach ($books as $book) {
            $ret[] = BookDtoFactory::create($book);
        }

        return $ret;
    }

    public function deleteBookById(int $id){
        return $this->dataAccess->deleteByID($id);
    }
}