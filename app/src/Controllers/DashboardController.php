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

        echo $this->twig->render('pages/home.twig', [
            'loggedIn' => $loggedIn,
            'home' => true
        ]);
    }
}
