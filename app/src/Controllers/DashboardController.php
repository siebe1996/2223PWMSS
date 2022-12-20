<?php
//namespace Controllers;
use Services\DatabaseConnector;
//require_once ('../../vendor/autoload.php');
//require_once ('../../config/database.php');
//require_once ('../../src/Services/DatabaseConnector.php');

class DashboardController
{
    protected \Doctrine\DBAL\Connection $db;
    protected \Twig\Environment $twig;

    public function __construct()
    {
        // initiate DB connection
        $this->conn = \Services\DatabaseConnector::getConnection();

        // bootstrap Twig
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
        $this->twig = new \Twig\Environment($loader);
        $function = new \Twig\TwigFunction('url', function ($path) {
            return BASE_PATH . $path;
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
        $formErrors = isset($_SESSION['flash']['errors']['trip']) ? trim($_SESSION['flash']['errors']['trip']) :  '';
        $startHouseNumber = isset($_SESSION['startHouseNumber']) ? trim($_SESSION['startHouseNumber']) : '';
        $startStreet = isset($_SESSION['startStreet']) ? trim($_SESSION['startStreet']) : '';
        $startCity = isset($_SESSION['startCity']) ? trim($_SESSION['startCity']) : '';
        $endHouseNumber = isset($_SESSION['endHouseNumber']) ? trim($_SESSION['endHouseNumber']) : '';
        $endStreet = isset($_SESSION['endStreet']) ? trim($_SESSION['endStreet']) : '';
        $endCity = isset($_SESSION['endCity']) ? trim($_SESSION['endCity']) : '';
        $time = isset($_SESSION['time']) ? trim($_SESSION['time']) : '';
        $date = isset($_SESSION['date']) ? trim($_SESSION['date']) : '';

        echo $this->twig->render('pages/home.twig', [
            'loggedIn' => $loggedIn,
            'home' => true,
            'errors' => $formErrors,
            'startHouseNumber' => $startHouseNumber,
            'startStreet' => $startStreet,
            'startCity' => $startCity,
            'endHouseNumber' => $endHouseNumber,
            'endStreet' => $endStreet,
            'endCity' => $endCity,
            'time' => $time,
            'date' => $date
        ]);
    }

    public function showAbout()
    {
        echo $this->twig->render('pages/about.twig', [
            'loggedIn' => isset($_SESSION['user'])
        ]);
    }
}
