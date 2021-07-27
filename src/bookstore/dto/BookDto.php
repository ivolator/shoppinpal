<?php

namespace bookstore\dto;

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
    protected int $id = 0;

    /**
     * Author name from the Author model
     * @var string
     */
    protected string $author = '';

    /**
     * Book title
     * @var string
     */
    protected string $title = '';
    /**
     * @var string Book isbn
     */
    protected string $isbn = '';

    /**
     * Book release date
     * @var string
     */
    protected string $releaseDate = '';

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
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
     * @return $this
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
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
     * @return $this
     */
    public function setTitle(string $title): self
    {

        $this->title = $title;
        return $this;
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
     * @return $this
     */
    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;
        return $this;
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
     * @return $this
     */
    public function setReleaseDate(string $releaseDate): self
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * @return false|mixed|string
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}