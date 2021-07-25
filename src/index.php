<?php
ini_set('display_errors', 'On');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
use bookstore\controllers\BookController;
use bookstore\controllers\Router;
use bookstore\repository\BookDataAccess;
use bookstore\repository\BookRepository;
use bookstore\repository\Connection;
use bookstore\services\Request;
use bookstore\services\Response;

require_once './class_loader.php';
$request = new Request();


$method = $request->getMethod();
$controller = new BookController(new BookRepository(new BookDataAccess(new Connection())));

//poor man's routing
$router = new Router($method, $controller);
$router->route($method, $controller, $request);

exit;

