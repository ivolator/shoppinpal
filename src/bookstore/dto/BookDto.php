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
        if (empty($author)){
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
        if (empty($title)){
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
        if (empty($isbn)){
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
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return false|mixed|string
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}