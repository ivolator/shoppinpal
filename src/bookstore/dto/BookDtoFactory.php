<?php


namespace bookstore\dto;


use bookstore\models\Book;

class BookDtoFactory
{
    /**
     * Create a DTO from an assoc array
     * @param Book $book
     * @return BookDto
     * @throws \bookstore\exceptions\Exception400
     */
    public static function create(array $book): BookDto
    {
        $bookDto = new BookDto();
        $bookDto->setId($book['id'] ?? 0);
        $bookDto->setTitle($book['title'] ?? '');
        $bookDto->setReleaseDate($book['releaseDate'] ?? '');
        $bookDto->setIsbn($book['isbn'] ?? '');
        $bookDto->setAuthor($book['author'] ?? '');
        return $bookDto;
    }

}