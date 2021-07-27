<?php


namespace bookstore\controllers;


use bookstore\dto\BookDto;
use bookstore\dto\Result;
use bookstore\services\JsonOutput;
use bookstore\services\Request;

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
    public function route(string $method, BookController $controller, Request $request)
    {
        switch ($method) {
            case 'POST' :
                //assuming application/json headers
                $book = json_decode($request->getRawPost());
                if (JSON_ERROR_NONE == json_last_error()) {
                    $response = $controller->createBook((array) $book);
                    return (new JsonOutput())->convertToJson($response);
                }
                return (new JsonOutput())->convertToJson((new Result())->addError('There was an issue with the JSON payload', 404));
            case 'GET':
                $ids = $request->get('ids', '');
                $books = $controller->getBooks($ids ?: []);
                return (new JsonOutput())->convertToJson($books);
            case 'DELETE':
                $ids = $request->get('ids', '');
                $result = $controller->deleteBooks($ids ?: []);
                return (new JsonOutput())->convertToJson($result);
            case 'PUT' :
                echo 'PUT';

            default;
        }
    }
}