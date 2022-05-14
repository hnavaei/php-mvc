<?php

include_once "../vendor/autoload.php";

use app\controllers\AuthController;
use app\core\Application;
use app\controllers\HomeController;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = array(
    'userClass' => \app\models\User::class,
    'db' => [
        'user' => $_ENV['DB_USER'],
        'dsn' => $_ENV['DB_DSN'],
        'pass' => $_ENV['DB_PASSWORD']
    ]

);

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/php-mvc/', [HomeController::class, 'home']);
$app->router->get('/php-mvc/register/', [AuthController::class, 'register']);
$app->router->post('/php-mvc/register/', [AuthController::class, 'register']);
$app->router->get('/php-mvc/login/', [AuthController::class, 'login']);
$app->router->post('/php-mvc/login/', [AuthController::class, 'login']);
$app->router->get('/php-mvc/logout/', [AuthController::class, 'logout']);
$app->router->post('/php-mvc/logout/', [AuthController::class, 'logout']);
$app->router->get('/php-mvc/profile/', [AuthController::class, 'profile']);
$app->router->post('/php-mvc/profile/', [AuthController::class, 'profile']);


$app->run();


Application::$app->db->applyMigrations();