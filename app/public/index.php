<?php
require_once('../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

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
$router->before('GET|POST', '/drivers/create', function () {
    if (!isset($_SESSION['user'])) {
        header('location: ../login');
        exit();
    }
});

$router->get('/', 'DashboardController@show');
$router->post('/', 'DashboardController@add');
//$router->post('/', 'TripController@add');
$router->get('/about', 'DashboardController@showAbout');
$router->get('/user', 'UserController@showAccountInfo');
$router->get('/login', 'UserController@showLogin');
$router->post('/login', 'UserController@login');
$router->get('/logout', 'UserController@logout');
$router->get('/register', 'UserController@showRegister');
$router->post('/register', 'UserController@Register');
$router->get('/drivers/create', 'DriverController@show');
$router->post('/drivers/create', 'DriverController@add');
$router->get('/verification', 'VerificationController@show');
$router->post('/verification', 'VerificationController@verification');

//$router->get('/requestPending', 'DashboardController@showRequestPending'); //driver/ride
$router->post('/rides/(\d+)/accept', 'TripController@acceptRide'); //driver/ride/accept  driver/ride/cancel
$router->post('/rides/(\d+)/cancelstartfinish', 'TripController@cancelStartFinishRide');
$router->get('/drivers/(\d+)', 'DriverController@showDriverInfo');
$router->get('/rides', 'TripController@showAvailableRides');

$router->run();
