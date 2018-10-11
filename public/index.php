<?php

session_start();

require_once './../vendor/autoload.php';

$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$router = new \Quantox\Http\Routing\Router();

$router->register('GET', '/', \Quantox\Http\Controllers\Controller::class, 'home');
$router->register('GET', '/login', \Quantox\Http\Controllers\Controller::class, 'login');
$router->register('GET', '/register', \Quantox\Http\Controllers\Controller::class, 'register');
$router->register('POST', '/results', \Quantox\Http\Controllers\Controller::class, 'results');
$router->register('POST', '/register', \Quantox\Http\Controllers\UserController::class, 'register');
$router->register('POST', '/login', \Quantox\Http\Controllers\UserController::class, 'login');

$router->emitResponse($request);

