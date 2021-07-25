<?php


namespace bookstore\repository;


use bookstore\models\Author;

/**
 * Class AuthorRepository
 * @package bookstore\repository
 */
class AuthorRepository
{

    /**
     * @var AuthorDataAccess
     */
    protected AuthorDataAccess $dataAccess;

    /**
     * AuthorRepository constructor.
     * @param AuthorDataAccess $dataAccess
     */
    public function __construct(AuthorDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }
    /**
     * @param integer $id
     * @return Author
     */
    public function findAuthorById(integer $id): Author
    {
    }

    /**
     * @param integer $id
     * @return Author
     */
    public function findAuthorByName(integer $id): Author
    {

    }
}