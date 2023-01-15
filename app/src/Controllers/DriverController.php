<?php
//namespace Controllers;
//require_once ('../../vendor/autoload.php');
//require_once ('../../config/database.php');
//require_once ('../../src/Services/DatabaseConnector.php');

use Services\VIESValidatorService;

class DriverController
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
        $formErrors = isset($_SESSION['flash']['errors']['driver']) ? $_SESSION['flash']['errors']['driver'] : '';
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
            'pathToRoot' => '../',
            'driverRegister' => true,
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

        if (strlen($numberPlate) > 8) {
            $formErrors['numberPlate'] = 'Voer een geldige nummerplaat in';
        }

        $birthDate_arr = explode('-', $birthDate);
        if (!checkdate($birthDate_arr[1], $birthDate_arr[2], $birthDate_arr[0])) {
            $formErrors['birthDate'] = 'Voer een geldige geboorte datum in ' . $birthDate_arr[1];
        }

        if (!in_array($gender, $genders)) {
            $formErrors['gender'] = 'Voer een geldige gender in';
        }

        if (isset($_FILES['profilePic']) && ($_FILES['profilePic']['error'] === UPLOAD_ERR_OK)) {

            if ((new SplFileInfo($_FILES['profilePic']['name']))->getExtension() == 'jpg') {
                $moved = @move_uploaded_file($_FILES['profilePic']['tmp_name'], './profilepic/' . $_SESSION['user']['id'] . '.jpg');
                if (!$moved) {
                    $formErrors['profilePic'] = 'Error while saving file in the uploads folder';
                }
            } else {
                $formErrors['profilePic'] = 'Invalid extension. Only .jpg allowed';
            }
        }

        if (trim($carBrand) === '') {
            $formErrors['carBrand'] = 'Voer een geldig automerk in';
        }

        if (trim($carModel) === '') {
            $formErrors['carModel'] = 'Voer een geldig automodel in';
        }

        $filter_options = array(
            'options' => array(
                'min_range' => 1,
                'max_range' => 10
            )
        );

        if (!filter_var($carPassengers, FILTER_VALIDATE_INT, $filter_options)) {
            $formErrors['carPassengers'] = 'Voer een geldig aantal passagiers in tussen 1 en 10';
        }

        if (!VIESValidatorService::validate($btwNumber)) {
            $formErrors['btwNumber'] = 'Voer een geldig btw nummer in';
        }

        //  if no errors: insert values into database

        if (!$formErrors) {
            $stmt = $this->conn->prepare('INSERT INTO drivers (id, number_plate, birth_date, car_seats, car_model, car_brand, gender, profile_pic, btw_nr) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $result = $stmt->executeStatement([(int)$_SESSION['user']['id'], $numberPlate, $birthDate, $carPassengers, $carModel, $carBrand, $gender, (int)$_SESSION['user']['id'] . '.jpg', $btwNumber]);
            header('location: /');
            exit();
        } else {
            $driver = ['numberPlate' => $numberPlate, 'birthDate' => $birthDate, 'gender' => $gender, 'carBrand' => $carBrand, 'carModel' => $carModel, 'carPassengers' => $carPassengers, 'btwNumber' => $btwNumber];
            $_SESSION['flash']['driver'] = $driver;
            $_SESSION['flash']['errors'] = ['driver' => $formErrors];
            header('location: create');
            exit;
        }
    }

    public function showDriverInfo($id)
    {
        $loggedIn = false;
        if (isset($_SESSION['user'])) {
            $loggedIn = true;
        }
        $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];

        $stmt = $this->conn->prepare('SELECT * FROM anonymous_users as anon INNER JOIN drivers as d on anon.id = d.id WHERE d.id = ?');
        $result = $stmt->executeQuery([$id]);
        $driver = $result->fetchAssociative();
        //als user geen driver is of niet bestaat redirect naar home;
        if (!$driver) {
            header('location: /');
            exit();
        }
        $stmt = $this->conn->prepare('SELECT * FROM trips as t WHERE t.driver_id = ? AND t.status = "finished"');
        /*$stmt = $this->conn->prepare(<<<'SQL'
            SELECT
                start_city AS fromCity,
                stop_city AS toCity,
                start_time AS date,
                price AS cost,
                DAYNAME(start_time) as day,
                
                                  
            FROM trips as t WHERE t.driver_id = ? AND t.status = "finished"
            SQL
        );*/
        $result = $stmt->executeQuery([$id]);
        $trips = $result->fetchAllAssociative();

        echo $this->twig->render('pages/account.twig', [
            'user' => [
                'name' => $driver['first_name'] . ' ' . $driver['last_name'],
                'email' => $driver['email'],
                'gender' => $driver['gender'],
                'car' => $driver['car_brand'],
                'model' => $driver['car_model'],
                'seats' => $driver['car_seats'],
                'status' => 'Driver',
                'rideAmount' => count($trips),
                'rideHistory' => $trips,
                'id' => $id,
            ],
            'userStatus' => $_SESSION['user']['status'],
            'driverInfo' => true,
            'months' => $months,
            'month' => -1,
            'loggedIn' => $loggedIn
        ]);
    }

    public function search($id)
    {
        if (!isset($_SESSION['user'])) {
            header('location: ../login');
            exit();
        }
        $search = isset($_POST['month']) ? trim($_POST['month']) : '';

        header('location:/drivers/' . $id . '/month/' . urlencode($search));
        exit();
    }

    public function showSearchResults($id, $month)
    {
        $loggedIn = false;
        if (isset($_SESSION['user'])) {
            $loggedIn = true;
        }
        $id = urldecode($id);
        $month = urldecode($month);

        $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];

        $stmt = $this->conn->prepare('SELECT * FROM anonymous_users as anon JOIN drivers as d on anon.id = d.id WHERE d.id = ?');
        $result = $stmt->executeQuery([$id]);
        $driver = $result->fetchAssociative();
        if (!$driver) {
            header('location: /');
            exit();
        }

        $stmt = $this->conn->prepare('SELECT COUNT(*) FROM trips as t WHERE t.driver_id = ? AND t.status = "finished"');
        $result = $stmt->executeQuery([$id]);
        $tripsCount = $result->fetchOne();

        $matches = array();
        if ($month < 13) {
            $stmt = $this->conn->prepare('SELECT * FROM trips as t WHERE t.driver_id = ? AND t.status = "finished" AND MONTH(t.start_time) = ?');
            $results = $stmt->executeQuery([$id, $month]);
            $matches = $results->fetchAllAssociative();
        } else {
            header('location: /drivers/' . $id);
            exit();
        }

        echo $this->twig->render('pages/account.twig', [
            'user' => [
                'name' => $driver['first_name'] . ' ' . $driver['last_name'],
                'email' => $driver['email'],
                'gender' => $driver['gender'],
                'car' => $driver['car_brand'],
                'model' => $driver['car_model'],
                'seats' => $driver['car_seats'],
                'status' => 'Driver',
                'rideAmount' => $tripsCount,
                'rideHistory' => $matches,
                'id' => $id,
            ],
            'driverInfo' => true,
            'months' => $months,
            'month' => $month,
            'loggedIn' => $loggedIn
        ]);
    }
}
