<?php

namespace bookstore\controllers;

use bookstore\dto\BookDto;
use bookstore\dto\Result;
use bookstore\services\Request;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    /**
     * Ensure GET controller method is called
     */
    public function testRouteGoesToGet()
    {
        $book = new BookDto();
        $book->setAuthor('A1');
        $book->setIsbn('ISBN1');
        $book->setTitle('T1');

        $controller = $this->getMockBuilder(BookController::class)->disableOriginalConstructor()->getMock();
        $controller->expects(self::once())->method('getBooks')->willReturn((new Result())->setData($book));

        $request = $this->getMockBuilder(Request::class)->getMock();
        $request->expects(self::once())->method('get')->willReturn([1, 2, 3, 4]);

        $r = new Router();
        $r->route('GET', $controller, $request);
    }
    /**
     * Ensure DELETE controller method is called
     */
    public function testRouteGoesToDelete()
    {
        $book = new BookDto();
        $book->setAuthor('A1');
        $book->setIsbn('ISBN1');
        $book->setTitle('T1');

        $controller = $this->getMockBuilder(BookController::class)->disableOriginalConstructor()->getMock();
        $controller->expects(self::once())->method('deleteBooks')->willReturn((new Result())->setData(true));

        $request = $this->getMockBuilder(Request::class)->getMock();
        $request->expects(self::once())->method('get')->willReturn([1,2,3]);

        $r = new Router();
        $r->route('DELETE', $controller, $request);
    }

}
