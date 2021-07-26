<?php


namespace bookstore\controllers;


use bookstore\services\Request;
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
    public function route(string $method, BookController $controller,Request $request)
    {

        switch ($method) {
            case 'POST' :
                break;
            case 'GET':
                $ids = $request->get('ids', '');
                $books = $controller->getBooks($ids?:[]);
                return (new JsonOutput())->convertToJson($books);
            case 'DELETE':
                $ids = $request->get('ids', '');
                $result = $controller->deleteBooks($ids?:[]);
                return (new JsonOutput())->convertToJson($result);
            case 'PUT' :
                echo 'PUT';

            default;
        }
    }
}