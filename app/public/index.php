<?php
require_once('../vendor/autoload.php');

$router = new \Bramus\Router\Router();
//$router->setNamespace('\Controllers');

$router = new \Bramus\Router\Router();

$router->get('/', 'DashboardController@show');
$router->get('/login', 'UserController@showLogin');
$router->post('/login', 'UserController@login');
$router->get('/register', 'UserController@showRegister');
$router->post('/register', 'UserController@register');
$router->get('/driver/create', 'DriverController@show');
$router->post('/driver/create', 'DriverController@add');
$router->get('/verification', 'VerificationController@show');

$router->run();
