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
    if ($_SESSION['user']['status'] !== 'Rider') {
        header('location: /');
        exit();
    }
});

$router->before('GET|POST', '/driver/.*', function () {
    if ($_SESSION['user']['status'] !== 'Driver') {
        header('location: /');
        exit();
    }
});

$router->get('/', 'DashboardController@show');
$router->post('/', 'DashboardController@add');
//$router->post('/', 'TripController@add');
$router->get('/about', 'DashboardController@showAbout');
$router->get('/users', 'UserController@showAccountInfo');
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
$router->post('/driver/rides/(\d+)/accept', 'TripController@acceptRide');
$router->get('/driver/rides/(\d+)/confirm', 'TripController@showConfirm');
$router->post('/driver/rides/(\d+)/confirm', 'TripController@confirm');
$router->post('/driver/rides/(\d+)/cancelstartfinish', 'TripController@cancelStartFinishRide');
$router->post('/rides/(\d+)/cancel', 'TripController@cancel');
$router->get('/drivers/(\d+)', 'DriverController@showDriverInfo');
$router->get('/drivers/(\d+)/month/(\d+)', 'DriverController@showSearchResults');
$router->post('/drivers/(\d+)/search', 'DriverController@search');
$router->get('/driver/rides', 'TripController@showAvailableRides');

$router->run();
