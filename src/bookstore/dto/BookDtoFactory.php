<?php


namespace bookstore\dto;


use bookstore\exceptions\Exception400;
use bookstore\models\Book;

/**
 * Class BookDtoFactory
 * @package bookstore\dto
 */
class BookDtoFactory
{
    /**
     * Create a DTO from an assoc array
     * @param array $book
     * @return BookDto
     * @throws Exception400
     */
    public function create(array $book): BookDto
    {
        $bookDto = new BookDto();
        $bookDto->setId($book['id'] ?? 0);
        $bookDto->setTitle($this->checkTitle($book['title']??'') ? $book['title'] : '');
        $bookDto->setIsbn($this->checkIsbn($book['isbn']??'') ? $book['isbn'] : '');
        $bookDto->setAuthor($this->checkAuthor($book['author']??'') ? $book['author'] : '');
        $bookDto->setReleaseDate($this->checkReleaseDate($book['releaseDate']??'') ? $book['releaseDate'] : "");
        return $bookDto;
    }

    /**
     * @param $title
     * @return bool
     * @throws Exception400
     */
    protected function checkTitle($title): bool
    {
        if (empty($title) or strlen($title) === 0) {
            throw new Exception400("Missing book Title name");
        }
        return true;
    }

    /**
     * @param $isbn
     * @return bool
     * @throws Exception400
     */
    protected function checkIsbn($isbn): bool
    {
        if (empty($isbn) or strlen($isbn) === 0) {
            throw new Exception400("Missing ISBN value");
        }
        return true;
    }

    /**
     * @param $author
     * @return bool
     * @throws Exception400
     */
    protected function checkAuthor($author): bool
    {
        if (empty($author) or strlen($author) === 0) {
            throw new Exception400("Missing book Author name");
        }
        return true;
    }

    /**
     * @param $releaseDate
     * @return bool
     * @throws Exception400
     */
    protected function checkReleaseDate($releaseDate): bool
    {

        if (empty($releaseDate)) {//can be empty
            return true;
        }

        $match = preg_match('/([0-9]{4}-[0-9]{2}-[0-9]{2})/', $releaseDate, $matches); //basic check mysql format check. Doesn't actually verify if it is a date string


        if (isset($match) and $match > 0) {
            return true;
        } else {
            throw new Exception400("Invalid date format. Use MySQL format");
        }
    }

}