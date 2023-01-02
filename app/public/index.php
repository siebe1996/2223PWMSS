<?php
require_once('../vendor/autoload.php');

$router = new \Bramus\Router\Router();
//$router->setNamespace('\Controllers');

$router = new \Bramus\Router\Router();

$router->before('GET|POST', '/.*', function () {
    session_start();
});

$router->before('GET|POST', '/login', function () {
    if (isset($_SESSION['user'])) {
        header('location: /');
        exit();
    }
});
$router->before('GET|POST', '/register', function () {
    if (isset($_SESSION['user'])) {
        header('location: /');
        exit();
    }
});
$router->before('GET|POST', '/driver/create', function () {
    if (!isset($_SESSION['user'])) {
        header('location: ../login');
        exit();
    }
});

$router->get('/', 'DashboardController@show');
$router->post('/', 'TripController@add');

$router->get('/requestPending','DashboardController@showRequestPending');
$router->get('/rideAccepted','DashboardController@showCancelRide');

$router->get('/about', 'DashboardController@showAbout');
$router->get('/user', 'UserController@showAccountInfo');
$router->get('/login', 'UserController@showLogin');
$router->post('/login', 'UserController@login');
$router->get('/logout', 'UserController@logout');
$router->get('/register', 'UserController@showRegister');
$router->post('/register', 'UserController@Register');
$router->get('/driver/create', 'DriverController@show');
$router->post('/driver/create', 'DriverController@add');
$router->get('/verification', 'VerificationController@show');

$router->run();
