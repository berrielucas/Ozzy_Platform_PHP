<?php

header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once 'vendor\autoload.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

require_once __DIR__ . '\app\config\conexao.php';
require_once __DIR__ . '\router\Router.php';
$router = new Router();
$router->run();

?>