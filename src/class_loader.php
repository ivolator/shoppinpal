<?php
use bookstore\ClassLoader;
/**
 * begin copy of the composer autoloader
 */
require_once 'ClassLoader.php';
$loader = new ClassLoader();
// register classes with namespaces
$loader->add('bookstore', __DIR__ . '/');
$loader->add('bookstore', __DIR__ . '../tests');
// activate the autoloader
$loader->register();
/**
 * end - copy of the composer autoloader
 */