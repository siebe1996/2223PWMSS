<?php
//namespace Controllers;
//require_once ('../../vendor/autoload.php');
//require_once ('../../config/database.php');
//require_once ('../../src/Services/DatabaseConnector.php');

use Services\LonLatService;
use Services\ShortestPathService;

class DashboardController
{
    protected \Doctrine\DBAL\Connection $conn;
    protected \Twig\Environment $twig;

    public function __construct()
    {
        // initiate DB connection
        $this->conn = \Services\DatabaseConnector::getConnection();

        // bootstrap Twig
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
        $this->twig = new \Twig\Environment($loader);
        $function = new \Twig\TwigFunction('url', function ($path) {
            return $_ENV['BASE_PATH'] . $path;
        });
        $this->twig->addFunction($function);
    }

    public function show()
    {
        if (isset($_SESSION['user'])) {
            $loggedIn = true;
        } else {
            $loggedIn = false;
        }
        $formErrors = $_SESSION['flash']['errors']['trip'] ?? '';
        $startHouseNumber = isset($_SESSION['flash']['trip']['startNumber']) ? trim($_SESSION['flash']['trip']['startNumber']) : '';
        $startStreet = isset($_SESSION['flash']['trip']['startStreet']) ? trim($_SESSION['flash']['trip']['startStreet']) : '';
        $startCity = isset($_SESSION['flash']['trip']['startCity']) ? trim($_SESSION['flash']['trip']['startCity']) : '';
        $endHouseNumber = isset($_SESSION['flash']['trip']['endNumber']) ? trim($_SESSION['flash']['trip']['endNumber']) : '';
        $endStreet = isset($_SESSION['flash']['trip']['endStreet']) ? trim($_SESSION['flash']['trip']['endStreet']) : '';
        $endCity = isset($_SESSION['flash']['trip']['endCity']) ? trim($_SESSION['flash']['trip']['endCity']) : '';
        $dateTime = isset($_SESSION['flash']['trip']['dateTime']) ? trim($_SESSION['flash']['trip']['dateTime']) : '';
        $email = isset($_SESSION['flash']['trip']['email']) ? trim($_SESSION['flash']['trip']['email']) : '';
        $firstName = isset($_SESSION['flash']['trip']['firstName']) ? trim($_SESSION['flash']['trip']['firstName']) : '';
        $lastName = isset($_SESSION['flash']['trip']['lastName']) ? trim($_SESSION['flash']['trip']['lastName']) : '';

        unset($_SESSION['flash']);


        echo $this->twig->render('pages/home.twig', [
            'loggedIn' => $loggedIn,
            'home' => true,
            'errors' => $formErrors,
            'startNumber' => $startHouseNumber,
            'startStreet' => $startStreet,
            'startCity' => $startCity,
            'endNumber' => $endHouseNumber,
            'endStreet' => $endStreet,
            'endCity' => $endCity,
            'dateTime' => $dateTime,
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'user' => [
                'status' => $_SESSION['user']['status'] ?? 'Rider'
            ]
        ]);
    }


    public function showRequestPending()
    {
        echo $this->twig->render('pages/cancelRide.twig', [
            'home' => true
        ]);
    }

    public function showAbout()
    {
        echo $this->twig->render('pages/about.twig', [
            'loggedIn' => isset($_SESSION['user']),
            'user' => [
                'status' => $_SESSION['user']['status'] ?? 'Rider'
            ]
        ]);
    }

    public function add()
    {
        if (isset($_SESSION['user'])) {
            $loggedIn = true;
        } else {
            $loggedIn = false;
        }
        $startHouseNumber = isset($_POST['startNumber']) ? trim($_POST['startNumber']) : '';
        $startStreet = isset($_POST['startStreet']) ? trim($_POST['startStreet']) : '';
        $startCity = isset($_POST['startCity']) ? trim($_POST['startCity']) : '';
        $endHouseNumber = isset($_POST['endNumber']) ? trim($_POST['endNumber']) : '';
        $endStreet = isset($_POST['endStreet']) ? trim($_POST['endStreet']) : '';
        $endCity = isset($_POST['endCity']) ? trim($_POST['endCity']) : '';
        $datetime = isset($_POST['dateTime']) ? trim($_POST['dateTime']) : '';
        $price = 0;
        $formErrors = [];

        if (trim($startHouseNumber) === '') {
            $formErrors['startNumber'] = 'Voer een geldig huisnummer in';
        }
        if (trim($startStreet) === '') {
            $formErrors['startStreet'] = 'Voer een geldige straat in';
        }
        if (trim($startCity) === '') {
            $formErrors['startCity'] = 'Voer een geldige stad in';
        }
        if (trim($endHouseNumber) === '') {
            $formErrors['endNumber'] = 'Voer een geldig huisnummer in';
        }
        if (trim($endStreet) === '') {
            $formErrors['endStreet'] = 'Voer een geldige straat in';
        }
        if (trim($endCity) === '') {
            $formErrors['endCity'] = 'Voer een geldige stad in';
        }

        if (trim($datetime) === ''){
            $formErrors['dateTime'] = 'Voer een geldige tijd en datum in ';
        }
        else{
            $dateTimeArr = explode('T', $datetime);
            $dateArr = explode('-', $dateTimeArr[0]);
            if (!checkdate($dateArr[1], $dateArr[2], $dateArr[0])) {
                $formErrors['dateTime'] = 'Voer een geldige datum in ';
            }
            if (!trim($dateTimeArr[1]) === '') {
                $formErrors['dateTime'] = 'Voer een geldige tijd in';
            }
        }

        $startCoords = LonLatService::search($startStreet . ' ' . $startHouseNumber . ' ' . $startCity);
        $endCoords = LonLatService::search($endStreet . ' ' . $endHouseNumber . ' ' . $endCity);

        $route = ShortestPathService::route($startCoords, $endCoords);
        $distance = $route['routes'][0]['distance'];
        if ($startCoords && $endCoords) {
            if ($distance > 100000) {
                $formErrors['startStreet'] = 'Trip is longer than 100km';
            }
            else {
                $price = 5 + $distance/1000*2;
            }
        }
        else {
            $startCoords ? $formErrors['endStreet'] = 'Ongledig eindadres' : $formErrors['startStreet'] = 'Ongeldig beginadres';
        }


        if (!$loggedIn) {
            $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
            $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            if (trim($firstName) === '') {
                $formErrors['firstName'] = 'Voer een voornaam in';
            } else if (!preg_match("/^[a-zA-Z-' ]+$/", $firstName)) {
                $formErrors['firstName'] = 'Voer een geldige voornaam in';
            }

            if (trim($lastName) === '') {
                $formErrors['lastName'] = 'Voer een achternaam in';
            } else if (!preg_match("/^[a-zA-Z-' ]+$/", $lastName)) {
                $formErrors['lastName'] = 'Voer een geldige achternaam in';
            }

            if (trim($email) === '') {
                $formErrors['email'] = 'Voer een email in';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $formErrors['email'] = 'Voer een geldige email in';
            }
            if (!$formErrors){
                $stmt = $this->conn->prepare('SELECT id FROM anonymous_users WHERE email = ?');
                $result = $stmt->executeQuery([$email]);
                $userId = $result->fetchOne();

                if(!$userId){
                    $stmt = $this->conn->prepare('INSERT INTO anonymous_users (email, first_name, last_name) VALUES (?, ?, ?)');
                    $result = $stmt->executeStatement([$email, $firstName, $lastName]);
                    $userId = $this->conn->fetchOne('SELECT LAST_INSERT_ID()', []);
                }
            }


            else {
                $stmt = $this->conn->prepare('INSERT INTO anonymous_users (email, first_name, last_name) VALUES (?, ?, ?)');
                $result = $stmt->executeStatement([$email, $firstName, $lastName]);
                $userId = $this->conn->fetchOne('SELECT LAST_INSERT_ID()', []);
            }
        } else {
            $userId = $_SESSION['user']['id'];
        }

        //  if no errors: insert values into database

        if (!$formErrors) {

            $stmt = $this->conn->prepare('INSERT INTO trips (start_nr, start_street, start_city, stop_nr, stop_street, stop_city, start_time, costumer_id, price) VALUES (?, ?, ?, ?, ?, ?, ? ,?, ?)');
            $result = $stmt->executeStatement([$startHouseNumber, $startStreet, $startCity, $endHouseNumber, $endStreet, $endCity, $datetime, $userId, $price]);
            header('location:/');
            exit();
        } else {
            $trip = ['startNumber' => $startHouseNumber, 'startStreet' => $startStreet, 'startCity' => $startCity, 'endNumber' => $endHouseNumber, 'endStreet' => $endStreet, 'endCity' => $endCity, 'dateTime' => $datetime, 'firstName' => $firstName, 'lastName' => $lastName, 'email' => $email];
            $_SESSION['flash']['trip'] = $trip;
            $_SESSION['flash']['errors'] = ['trip' => $formErrors];
            header('location:/');
            exit();
        }
    }
}
