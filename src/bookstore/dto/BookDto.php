<?php

namespace bookstore\dto;

use bookstore\exceptions\Exception400;
use JsonSerializable;

/**
 * Class BookDto
 * @package bookstore\dto
 */
class BookDto implements JsonSerializable
{
    /**
     * Book Id
     * @var int
     */
    protected int $id;

    /**
     * Author name from the Author model
     * @var string
     */
    protected string $author;

    /**
     * Book title
     * @var string
     */
    protected string $title;
    /**
     * @var string Book isbn
     */
    protected string $isbn;

    /**
     * Book release date
     * @var string
     */
    protected string $releaseDate;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        if (empty($id)) {
            throw new Exception400("Book ID can't be empty or 0");
        }
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @throws Exception400
     */
    public function setAuthor(string $author): void
    {
        if (empty($author) or strlen($author) === 0) {
            throw new Exception400("Missing book Author name");
        }
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @throws Exception400
     */
    public function setTitle(string $title): void
    {
        if (empty($title) or strlen($title) === 0) {
            throw new Exception400("Missing book Title name");
        }
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getIsbn(): string
    {
        return $this->isbn;
    }

    /**
     * @param string $isbn
     * @throws Exception400
     */
    public function setIsbn(string $isbn): void
    {
        if (empty($isbn) or strlen($isbn) == 0) {
            throw new Exception400("Missing ISBN value");
        }
        $this->isbn = $isbn;
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @param string $releaseDate
     * @throws Exception400
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $match = preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/', $releaseDate, $matches);
        if ($match > 0) {
            $this->releaseDate = $releaseDate;
        } else {
            throw new Exception400("Invalid date format. Use MySQL format");
        }
    }

    /**
     * @return false|mixed|string
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}