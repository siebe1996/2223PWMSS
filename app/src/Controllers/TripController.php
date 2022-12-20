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
        $startHouseNumber = isset($_POST['startNumber']) ? trim($_POST['startNumber']) : '';
        $startStreet = isset($_POST['startStreet']) ? trim($_POST['startStreet']) : '';
        $startCity = isset($_POST['startCity']) ? trim($_POST['startCity']) : '';
        $endHouseNumber = isset($_POST['endNumber']) ? trim($_POST['endNumber']) : '';
        $endStreet = isset($_POST['endStreet']) ? trim($_POST['endStreet']) : '';
        $endCity = isset($_POST['endCity']) ? trim($_POST['endCity']) : '';
        $datetime = isset($_POST['datetime']) ? trim($_POST['datetime']) : '';
        $formErrors = [];

        if (trim($startHouseNumber) === ''){
            $formErrors['startNumber'] = 'Voer een geldig huisnummer in';
        }
        if (trim($startStreet) === ''){
            $formErrors['startStreet'] = 'Voer een geldige straat in';
        }
        if (trim($startCity) === ''){
            $formErrors['startStreet'] = 'Voer een geldige straat in';
        }
        if (trim($endHouseNumber) === ''){
            $formErrors['endNumber'] = 'Voer een geldig huisnummer in';
        }
        if (trim($endStreet) === ''){
            $formErrors['endStreet'] = 'Voer een geldige straat in';
        }
        if (trim($endCity) === ''){
            $formErrors['endStreet'] = 'Voer een geldige straat in';
        }

        $dateTimeArr = explode('T', $datetime);
        $dateArr = explode('-', $dateTimeArr[0]);
        if (!checkdate($dateArr[1], $dateArr[2], $dateArr[0])) {
            $formErrors['datetime'] = 'Voer een geldige datum in ';
        }
        if (!trim($dateTimeArr[1]) === ''){
            $formErrors['datetime'] = 'Voer een geldige tijd in';
        }
        /*function validateDate($date) {
            $format = 'Y-m-d H:i';
            $dateTime = DateTime::createFromFormat($format, $date);

            if ($dateTime instanceof DateTime && $dateTime->format('Y-m-d H:i') == $date) {
                return $dateTime->getTimestamp();
            }

            return false;
        }*/

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
            $trip = ['startNumber' => $startHouseNumber, 'startStreet' => $startStreet, 'startCity' => $startCity, 'endNumber' => $endHouseNumber, 'endStreet' => $endStreet, 'endCity' => $endCity, 'datetime' => $datetime];
            $_SESSION['flash']['trip'] = $trip;
            $_SESSION['flash']['errors'] = ['trip' => $formErrors];
            header('Location : /');
        }
    }
}