<?php

class TripController
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

    public function add(){
        if (isset($_SESSION['user'])) {
            $loggedIn = true;
        } else {
            $loggedIn = false;
        }
        $startHouseNumber = isset($_POST['startHouseNumber']) ? trim($_POST['startHouseNumber']) : '';
        $startStreet = isset($_POST['startStreet']) ? trim($_POST['startStreet']) : '';
        $startCity = isset($_POST['startCity']) ? trim($_POST['startCity']) : '';
        $endHouseNumber = isset($_POST['endHouseNumber']) ? trim($_POST['endHouseNumber']) : '';
        $endStreet = isset($_POST['endStreet']) ? trim($_POST['endStreet']) : '';
        $endCity = isset($_POST['endCity']) ? trim($_POST['endCity']) : '';
        $time = isset($_POST['time']) ? trim($_POST['time']) : '';
        $date = isset($_POST['date']) ? trim($_POST['date']) : '';
        $formErrors = [];

        if (trim($startHouseNumber) === ''){
            $formErrors['startHouseNumber'] = 'Voer een geldig huisnummer in';
        }
        if (trim($startStreet) === ''){
            $formErrors['startStreet'] = 'Voer een geldige straat in';
        }
        if (trim($startCity) === ''){
            $formErrors['startStreet'] = 'Voer een geldige straat in';
        }
        if (trim($endHouseNumber) === ''){
            $formErrors['endHouseNumber'] = 'Voer een geldig huisnummer in';
        }
        if (trim($endStreet) === ''){
            $formErrors['endStreet'] = 'Voer een geldige straat in';
        }
        if (trim($endCity) === ''){
            $formErrors['endStreet'] = 'Voer een geldige straat in';
        }

        if (trim($time) === ''){
            $formErrors['time'] = 'Voer een geldige tijd in';
        }

        $date  = explode('-', $date);
        if (!checkdate($date[1], $date[2], $date[0])) {
            $formErrors['date'] = 'Voer een geldige datum in ';
        }
        if(!$loggedIn){
            //toDo als niet logged in extra velden controleren
        }
        else{
            //toDo extra velden uit $_SESSION['user'] halen
        }

        //  if no errors: insert values into database

        if (sizeof($formErrors) === 0){
            //toDo toevoegen databank
        }
        else{
            $_SESSION['flash']['errors'] = ['trip' => $formErrors];
            header('Location : /');
        }
    }
}