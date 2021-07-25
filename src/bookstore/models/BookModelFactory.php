<?php


namespace bookstore\models;


use bookstore\dto\BookDto;
use bookstore\exceptions\Exception400;
use bookstore\exceptions\Exception500;

/**
 * Class BookModelFactory
 * @package bookstore\models
 */
class BookModelFactory
{
    /**
     * Create a Book object to be saved to DB from a BookDto
     * @param BookDto $bookDto
     * @return Book
     * @throws Exception400
     * @throws Exception500
     */
    public function createBook(BookDto $bookDto): Book
    {
        $this->validate($bookDto);

    }

    /**
     * @param BookDto $bookDto
     * @return bool
     * @throws Exception400
     * @throws Exception500
     */
    protected function validate(BookDto $bookDto): bool
    {
        if (empty($bookDto)) {
            throw new Exception500("There was a server error");
        }
        //simple check
        if (empty($bookDto->getIsbn())) {
            throw new Exception400("There was an error with the ISBN input");
        }
        return true;
    }
}