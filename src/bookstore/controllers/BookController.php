<?php


namespace bookstore\controllers;

use bookstore\exceptions\Exception400;
use bookstore\exceptions\Exception500;
use bookstore\repository\BookRepository;
use bookstore\services\Response;
use Exception;

/**
 * Class BookController
 * @package bookstore
 */
class BookController
{

    protected BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     *
     * @throws Exception
     */
    public function getBooks(array $ids)
    {
        try {
            $books = $this->bookRepository->findBooksByIds($ids);
            $data = (new Response())->setResultObject(new Result())->send($books);
            return $data;
        } catch (Exception400 $e400) {
            return (new Response())->setResultObject(new Result())->shutdown($e400);
        } catch (Exception500 | Exception $e500) {
            return (new Response())->setResultObject(new Result())->shutdown($e500);
        }
    }
}