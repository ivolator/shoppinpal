<?php


namespace bookstore\controllers;

use bookstore\dto\BookDtoFactory;
use bookstore\dto\Result;
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
    protected Response $response;
    protected BookDtoFactory $bookDtoFactory;

    public function __construct(BookRepository $bookRepository, Response $response, BookDtoFactory $bookDtoFactory)
    {
        $this->response = $response ?: (new Response());
        $this->bookRepository = $bookRepository;
        $this->bookDtoFactory = $bookDtoFactory;
    }


    /**
     * @param array $book
     * @return Result
     * @throws Exception400
     */
    public function createBook(array $book): Result
    {
        $bookDto = $this->bookDtoFactory->create($book);
        $ret = $this->bookRepository->createBook($bookDto);
        return $this->response->setResultObject(new Result())->setStatus(Response::CREATED)->send($ret);

    }

    /**
     * Executed upon GET request with array of ids passed in the query string
     * The resource is at the root of the application
     * ids[]=1&ids[]=2&ids[]=3
     */
    public function getBooks(array $ids): Result
    {
        try {
            if (empty($ids)) {
                throw new Exception400('No ids were provided');
            }
            $books = $this->bookRepository->findBooksByIds($ids);
            return $this->response->setResultObject(new Result())->send($books);
        } catch (Exception400 $e400) {
            return $this->response->setResultObject(new Result())->shutdown($e400);
        } catch (Exception500 | Exception $e500) {
            return $this->response->setResultObject(new Result())->shutdown($e500);
        }
    }

    /**
     * Executed upon DELETE
     * Use a POST method with
     *   X-HTTP-METHOD-OVERRIDE header for DELETE
     * ids[]=1&ids[]=2&ids[]=3
     * The  "data" property in the response object is set to true on success for any found book deletions,
     * 404 when no books found, 500 if something goes wrong.
     *
     * @param array $ids
     * @return Result
     */
    public function deleteBooks(array $ids): Result
    {
        try {
            if (empty($ids)) {
                throw new Exception400('No ids were provided');
            }
            $books = $this->bookRepository->deleteBookById($ids);
            $data = (new Response())->setResultObject(new Result())->send($books);
            return $data;
        } catch (Exception400 $e400) {
            return (new Response())->setResultObject(new Result())->shutdown($e400);
        } catch (Exception500 | Exception $e500) {
            return (new Response())->setResultObject(new Result())->shutdown($e500);
        }
    }

    /**
     * @return BookRepository
     */
    public function getBookRepository(): BookRepository
    {
        return $this->bookRepository;
    }

    /**
     * @param BookRepository $bookRepository
     */
    public function setBookRepository(BookRepository $bookRepository): void
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }

    /**
     * @param BookDtoFactory $bookDtoFactory
     */
    public function setBookDtoFactory(BookDtoFactory $bookDtoFactory): self
    {
        $this->bookDtoFactory = $bookDtoFactory;
        return $this;
    }
}