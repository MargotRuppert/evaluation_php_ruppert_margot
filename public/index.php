<?php

//Import de l'autoloader
include __DIR__ . "/../vendor/autoload.php";

//Chargement des variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();

session_start();

use App\Controller\SecurityController;
use App\Controller\BookController;

use Mithridatem\Routing\Route;
use Mithridatem\Routing\Router;

$router = new Router();

$router->map(Route::controller('GET', '/register', SecurityController::class, 'register'));
$router->map(Route::controller('POST', '/register', SecurityController::class, 'register'));
$router->map(Route::controller('GET', '/login', SecurityController::class, 'login'));
$router->map(Route::controller('POST', '/login', SecurityController::class, 'login'));
$router->map(Route::controller('GET', '/logout', SecurityController::class, 'logout'));
$router->map(Route::controller('GET', '/book', BookController::class, 'book'));
$router->map(Route::controller('POST', '/book', BookController::class, 'book'));

$router->dispatch();