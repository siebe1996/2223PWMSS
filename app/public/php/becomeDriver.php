<?php
require_once ('../../vendor/autoload.php');
require_once ('../../config/database.php');
require_once ('../../src/Services/DatabaseConnector.php');

$conn = \Services\DatabaseConnector::getConnection();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
$twig = new \Twig\Environment($loader, [
        'cache' => __DIR__ . '/../../storage/cache',
        'auto_reload' => true
    ]
);
// start session (starts a new one, or continues the already started one)
session_start();

if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}

$numberPlate = isset($_POST['numberPlate']) ? $_POST['numberPlate'] : '';
$birthDate = isset($_POST['birthDate']) ? $_POST['birthDate'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$carBrand = isset($_POST['carBrand']) ? $_POST['carBrand'] : '';
$carModel = isset($_POST['carModel']) ? $_POST['carModel'] : '';
$carPassengers = isset($_POST['carPassengers']) ? $_POST['carPassengers'] : '';
$formErrors = [];
$genders = ['M', 'F', 'X'];

if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] === 'register')) {
    if (!preg_match("/^[a-zA-Z-' ]+$/",$numberPlate)){
        $formErrors['numberPlate'] = 'Voer een geldige nummerplaat in';
    }

    $birthDate_arr  = explode('-', $birthDate);
    if (!checkdate($birthDate_arr[0], $birthDate_arr[1], $birthDate_arr[2])) {
        $formErrors['birthDate'] = 'Voer een geldige geboorte datum in';
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

    //  if no errors: insert values into database

    if (sizeof($formErrors) === 0){
        // @toDO check errors connection
        $stmt = $conn->prepare('INSERT INTO drivers (id, number_plate, birth_date, car_seats, car_model, car_brand, gender, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $result = $stmt->executeStatement([(int)$_SESSION['user']['id'], $numberPlate, $birthDate, $carPassengers, $carModel, $carBrand, $gender, (int)$_SESSION['user']['id'] . '.jpg']);
        header('location: index.php');
        exit();

        //toDo redirect to conformation page;
    }
}

$becomeDriverPanel = $twig->load('/pages/becomeDriver.twig');
echo $becomeDriverPanel->render([
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
    'genders' => $genders,
    ]);