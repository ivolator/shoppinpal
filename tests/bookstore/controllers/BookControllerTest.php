<?php

namespace bookstore\controllers;

use bookstore\dto\BookDto;
use bookstore\dto\BookDtoFactory;
use bookstore\dto\Result;
use bookstore\exceptions\Exception400;
use bookstore\repository\BookRepository;
use bookstore\services\Response;
use PHPUnit\Framework\TestCase;

class BookControllerTest extends TestCase
{

    protected BookRepository $bookRepository;
    protected Response $response;
    protected BookDtoFactory $bookDtoFactory;

    public function setUp(): void
    {
        $this->bookRepository = $this->getMockBuilder(BookRepository::class)->disableOriginalConstructor()->getMock();
        $this->response = $this->getMockBuilder(Response::class)->enableProxyingToOriginalMethods()->getMock();
        $this->bookDtoFactory = $this->getMockBuilder(BookDtoFactory::class)->enableProxyingToOriginalMethods()->getMock();
    }

    /**
     *
     */
    public function testGetBooks()
    {
        $bookDtos = [(new BookDto()), (new BookDto())];
        $this->bookRepository->expects(self::once())->method('findBooksByIds')->willReturn($bookDtos);
        $this->response->method('send')->willReturn((new Result()));
        $controller = new BookController($this->bookRepository, $this->response, $this->bookDtoFactory);

        $data = $controller->getBooks([1, 2, 3]);
        $this->assertInstanceOf(Result::class, $data);
    }

    /**
     *
     */
    public function testThrowsExceptionAndCallsShutdown()
    {
        $this->bookRepository->expects(self::once())->method('findBooksByIds')->willReturn([]);
        $this->response->expects(self::never())->method('send');
        $controller = new BookController($this->bookRepository, $this->response, $this->bookDtoFactory);

        try {
            $controller->getBooks([1, 2, 3]);
        } catch (\Exception $e) {
            $this->response->expects(self::once())->method('shutdown');
        }
    }

    public function testDeleteBooks()
    {
        $this->bookRepository->expects(self::once())->method('deleteBookById')->willReturn(true);
        $this->response->method('send')->willReturn((new Result()));
        $controller = new BookController($this->bookRepository, $this->response, $this->bookDtoFactory);

        $data = $controller->deleteBooks([1, 2, 3]);
        $this->assertTrue($data->getData());
    }

    public function tesDeleteThrowsExceptionAndCallsShutdown()
    {
        $this->bookRepository->expects(self::any())->method('deleteBookById')->willReturn([]);
        $this->response->expects(self::never())->method('send');
        $controller = new BookController($this->bookRepository, $this->response, $this->bookDtoFactory);

        try {
            $controller->deleteBooks([1, 2, 3]);
        } catch (\Exception $e) {
            $this->response->expects(self::any())->method('shutdown');
        }
        $this->bookRepository->expects(self::any())->method('deleteBookById')->willThrowException(new Exception400('Some user error'));

        try {
            $controller->deleteBooks([1, 2, 3]);
        } catch (\Exception $e) {
            $this->response->expects(self::any())->method('shutdown');
        }
    }
}
