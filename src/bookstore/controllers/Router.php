<?php


namespace bookstore\controllers;


use bookstore\services\Response;
use bookstore\services\JsonOutput;

/**
 * Routes only based on the method of request. Not really a router based on path.
 * Class Router
 * @package bookstore\controllers
 */
class Router
{
    /**
     * @throws \Exception
     */
    public function route(string $method, BookController $controller, $request): void
    {

        switch ($method) {
            case 'POST' :
                echo $method;
                //        echo $controller->createBooks($book);
                break;
            case 'GET':
                $ids = $request->get('ids', '');
                $books = $controller->getBooks($ids);
                //encapsulate data in generic response
                echo (new JsonOutput())->convertToJson($books);
                //send
                break;
            case 'DELETE':
                echo 'PUT';
                break;
            case 'PUT' :
                echo 'PUT';

            default;
        }
    }
}