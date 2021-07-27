<?php
$conf = [
    'mysqlUser' => getenv('MYSQL_USER') ?? '',
    'mysqlPassword' => $_ENV['MYSQL_PASSWORD'] ?? '',
    'mysqlHost' => $_ENV['MYSQL_HOST'] ?? '',
    'mysqlDb' => $_ENV['MYSQL_DB'] ?? '',
];
 
