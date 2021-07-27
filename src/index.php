<?php
ini_set('display_errors', 'On');
error_reporting(E_ERROR | E_WARNING | E_PARSE);

use bookstore\controllers\BookController;
use bookstore\controllers\Router;
use bookstore\dto\BookDtoFactory;
use bookstore\dto\Result;
use bookstore\repository\BookDataAccess;
use bookstore\repository\BookRepository;
use bookstore\repository\Connection;
use bookstore\services\Request;
use bookstore\services\Response;

require_once './class_loader.php';
$conf=[];
include_once './config.php';

$request = new Request();
$method = $request->getMethod();
$bookDtoFactory = new BookDtoFactory();
$bookRepository = new BookRepository(new BookDataAccess(new Connection($conf['mysqlDb'], $conf['mysqlHost'], $conf['mysqlUser'], $conf['mysqlPassword'])), $bookDtoFactory);
$controller = new BookController($bookRepository, new Response(), $bookDtoFactory);

//poor man's routing
$router = new Router($method, $controller);
try {
    //route based on method
    echo $router->route($method, $controller, $request);
} catch (Exception $e) {
    //anything that passes through
    $ret = (new Response())->setResultObject(new Result())->setStatus(Response::INTERNALSERVERERROR)->shutdown($e);
    echo json_encode($ret);
}

exit;

