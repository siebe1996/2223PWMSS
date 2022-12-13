<?php
//namespace Controllers;
use Services\DatabaseConnector;
//require_once ('../../vendor/autoload.php');
//require_once ('../../config/database.php');
//require_once ('../../src/Services/DatabaseConnector.php');

class DriverController
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
        //start session
        session_start();
        //redirect to index if logged in
        if (!isset($_SESSION['user'])) {
            header('location: /');
            exit();
        }
    }

    public function show()
    {
        $formErrors = isset($_SESSION['flash']['errors']['driver']) ? trim($_SESSION['flash']['errors']['driver']) :  '';
        $numberPlate = isset($_SESSION['flash']['driver']['numberPlate']) ? trim($_SESSION['flash']['driver']['numberPlate']) : '';
        $birthDate = isset($_SESSION['flash']['driver']['birthDate']) ? trim($_SESSION['flash']['driver']['birthDate']) : '';
        $gender = isset($_SESSION['flash']['driver']['gender']) ? trim($_SESSION['flash']['driver']['gender']) : '';
        $carBrand = isset($_SESSION['flash']['driver']['carBrand']) ? trim($_SESSION['flash']['driver']['carBrand']) : '';
        $carModel = isset($_SESSION['flash']['driver']['carModel']) ? trim($_SESSION['flash']['driver']['carModel']) : '';
        $carPassengers = isset($_SESSION['flash']['driver']['carPassengers']) ? trim($_SESSION['flash']['driver']['carPassengers']) : '';
        $btwNumber = isset($_SESSION['flash']['driver']['btwNumber']) ? trim($_SESSION['flash']['driver']['btwNumber']) : '';
        $genders = ['M', 'F', 'X'];
        unset($_SESSION['flash']);

        echo $this->twig->render('pages/becomeDriver.twig', [
            'pathToRoot'=>'../',
            'driverRegister'=>true,
            'loggedIn' => true,
            'errors' => $formErrors,
            'numberPlate' => $numberPlate,
            'birthDate' => $birthDate,
            'gender' => $gender,
            'carBrand' => $carBrand,
            'carModel' => $carModel,
            'carPassengers' => $carPassengers,
            'btwNumber' => $btwNumber,
            'genders' => $genders,
        ]);
    }

    public function add()
    {
        $numberPlate = isset($_POST['numberPlate']) ? trim($_POST['numberPlate']) : '';
        $birthDate = isset($_POST['birthDate']) ? trim($_POST['birthDate']) : '';
        $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
        $carBrand = isset($_POST['carBrand']) ? trim($_POST['carBrand']) : '';
        $carModel = isset($_POST['carModel']) ? trim($_POST['carModel']) : '';
        $carPassengers = isset($_POST['carPassengers']) ? trim($_POST['carPassengers']) : '';
        $btwNumber = isset($_POST['btwNumber']) ? trim($_POST['btwNumber']) : '';
        $genders = ['M', 'F', 'X'];
        $formErrors = [];

        if (!preg_match("/^[a-zA-Z-' ]+$/",$numberPlate)){
            $formErrors['numberPlate'] = 'Voer een geldige nummerplaat in';
        }

        $birthDate_arr  = explode('-', $birthDate);
        if (!checkdate($birthDate_arr[1], $birthDate_arr[2], $birthDate_arr[0])) {
            $formErrors['birthDate'] = 'Voer een geldige geboorte datum in ' . $birthDate_arr[1];
        }

        if(!in_array($gender, $genders)){
            $formErrors['gender'] = 'Voer een geldige gender in';
        }

        if (isset($_FILES['profilePic']) && ($_FILES['profilePic']['error'] === UPLOAD_ERR_OK)) {

            if ((new SplFileInfo($_FILES['profilePic']['name']))->getExtension() == 'jpg') {
                $moved = @move_uploaded_file($_FILES['profilePic']['tmp_name'], '../../storage/images/' . $_SESSION['user']['id'] . '.jpg');
                if (!$moved) {
                    $formErrors['profilePic'] = 'Error while saving file in the uploads folder';
                }
            } else {
                $formErrors['profilePic'] = 'Invalid extension. Only .jpg allowed';
            }
        }

        if (trim($carBrand) === ''){
            $formErrors['carBrand'] = 'Voer een geldig automerk in';
        }

        if (trim($carModel) === ''){
            $formErrors['carModel'] = 'Voer een geldig automodel in';
        }

        $filter_options = array(
            'options' => array( 'min_range' => 1,
                'max_range' => 10 )
        );

        if( !filter_var( $carPassengers, FILTER_VALIDATE_INT, $filter_options )) {
            $formErrors['carPassengers'] = 'Voer een geldig aantal passagiers in tussen 1 en 10';
        }

        if(!\Services\VIESValidatorService::validate($btwNumber)) {
            $formErrors['btwNumber'] = 'Voer een geldig btw nummer in';
        }

        //  if no errors: insert values into database

        if (sizeof($formErrors) === 0){
            $stmt = $this->conn->prepare('INSERT INTO drivers (id, number_plate, birth_date, car_seats, car_model, car_brand, gender, profile_pic, btw_nr) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $result = $stmt->executeStatement([(int)$_SESSION['user']['id'], $numberPlate, $birthDate, $carPassengers, $carModel, $carBrand, $gender, (int)$_SESSION['user']['id'] . '.jpg', $btwNumber]);
            header('location: /');
            exit();

            //toDo als je bestuurder bent kun je nie opnieuw inschrijven
        }
        else{
            $_SESSION['flash']['errors'] = ['driver' => $formErrors];
            header('Location : driver/create');
        }
    }
}

