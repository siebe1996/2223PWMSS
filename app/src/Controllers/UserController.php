<?php
//namespace Controllers;

//require_once ('../../vendor/autoload.php');
//require_once ('../../config/database.php');
//require_once ('../../src/Services/DatabaseConnector.php');

use Services\MailService;

class UserController
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

    public function showLogin()
    {
        $formErrors = isset($_SESSION['flash']['errors']['login']) ? trim($_SESSION['flash']['errors']['login']) : '';
        $email = isset($_SESSION['flash']['login']['email']) ? trim($_SESSION['flash']['login']['email']) : '';
        unset($_SESSION['flash']);

        echo $this->twig->render('pages/login.twig', [
            'error' => $formErrors,
            'disappearingSVG' => true,
            'loggedIn' => false,
            'email' => $email
        ]);
    }

    public function login()
    {
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $formErrors = '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $formErrors = 'Please enter valid credentials';
        }
        if ($password === '') {
            $formErrors = 'Please enter valid credentials';
        }

        if ($formErrors) {
            $_SESSION['flash']['login']['email'] = $email;
            $_SESSION['flash']['errors'] = ['login' => $formErrors];
            header('location:/login');
            exit();
        }

        $user = $this->conn->fetchAssociative('SELECT 
        anon.id, 
        anon.email, 
        anon.first_name, 
        anon.last_name, 
        u.password, 
        u.verified 
        FROM anonymous_users AS anon, users AS u WHERE email = ? AND anon.id = u.id/', [$email]);

        if (!empty($user)) {
            if ($user['verified']) {
                if (password_verify($password, $user['password'])) {

                    $userStatus = $this->conn
                        ->fetchAssociative('SELECT id FROM drivers WHERE id = ?', [$user['id']]);
                    $user['status'] = $userStatus ? 'Driver' : 'Rider';

                    // Store the user row in the session
                    $_SESSION['user'] = $user;
                    header('location:/');
                    exit();
                } // Invalid login
                else {
                    $formErrors = 'Please enter valid credentials';
                    $_SESSION['flash']['login']['email'] = $email;
                    $_SESSION['flash']['errors'] = ['login' => $formErrors];
                    header('location:/login');
                    exit();
                }
            } else {
                $formErrors = 'Please validate user';
                $_SESSION['flash']['login']['email'] = $email;
                $_SESSION['flash']['errors'] = ['login' => $formErrors];
                header('location:/login');
                exit();
            }
        } // username & password are not valid
        else {
            $formErrors = 'Please enter valid credentials';
            $_SESSION['flash']['login']['email'] = $email;
            $_SESSION['flash']['errors'] = ['login' => $formErrors];
            header('location:/login');
            exit();
        }
    }

    public function showRegister()
    {
        $firstName = isset($_SESSION['flash']['register']['firstName']) ? trim($_SESSION['flash']['register']['firstName']) : '';
        $lastName = isset($_SESSION['flash']['register']['lastName']) ? trim($_SESSION['flash']['register']['lastName']) : '';
        $email = isset($_SESSION['flash']['register']['email']) ? trim($_SESSION['flash']['register']['email']) : '';
        $formErrors = $_SESSION['flash']['errors']['register'] ?? '';
        unset($_SESSION['flash']);
        echo $this->twig->render('pages/register.twig', [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'errors' => $formErrors,
            'loggedIn' => false,
        ]);
    }

    public function register()
    {
        $firstName = $_POST['firstName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $email = $_POST['email'] ?? '';
        $formErrors = [];;

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
        } else {
            $stmt = $this->conn->prepare('SELECT * FROM anonymous_users WHERE email = ?');
            $result = $stmt->executeQuery([$email]);
            $anonymous_user = $result->fetchAssociative();

            if (!empty($anonymous_user)) {
                $formErrors['email'] = 'Er bestaat al een gebruiker met dit e-mailadres';
            }
        }

        if ($formErrors) {
            $register = ['firstName' => $firstName, 'lastName' => $lastName, 'email' => $email];
            $_SESSION['flash']['register'] = $register;
            $_SESSION['flash']['errors'] = ['register' => $formErrors];
            header('location:register');
            exit;
        }

        $verificationCode = substr(str_shuffle(implode(range('A', 'Z'))), 0, 16);

        $stmt = $this->conn->prepare('INSERT INTO anonymous_users (email, first_name, last_name) VALUES (?, ?, ?)');
        $result = $stmt->executeStatement([$email, $firstName, $lastName]);
        $stmt2 = $this->conn->prepare('SELECT id FROM anonymous_users WHERE email = ?');
        $result2 = $stmt2->executeQuery([$email]);
        $userId = $result2->fetchOne();
        $stmt3 = $this->conn->prepare('INSERT INTO users (id, verification_code) VALUES (?,?)');
        $result3 = $stmt3->executeStatement([$userId, $verificationCode]);

        MailService::send($this->twig, 'info@rebu.be', $email, 'Verifieer je account', 'Je verificatiecode is: ' . $verificationCode, 'email/verificatiecode.twig', [
            'verificationCode' => $verificationCode,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'userId' => $userId
        ]);

        header('location:/verification');
        exit();
    }

    public function logout()
    {
        session_destroy();

        header('Location:/login');
        exit();
    }

    public function showAccountInfo()
    {
        if (!isset($_SESSION['user'])) {
            header('location:/');
            exit();
        }
        $userId = $_SESSION['user']['id'];
        if ($_SESSION['user']['status'] == 'Driver') {
            header('location:/drivers/' . $_SESSION['user']['id']);
        }


        $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];


        $trips = $this->conn
            ->prepare('SELECT CONCAT(start_nr, " ", start_street, ", ", start_city) AS fullAddressFrom,
                CONCAT(stop_nr, " ", stop_street, ", ", stop_city) AS fullAddressTo,
                price,
                start_city AS fromCity,
                stop_city AS toCity,
                start_time AS time,
                id 
                FROM trips WHERE costumer_id = ? AND status = "finished" ORDER BY start_time DESC')
            ->executeQuery([$_SESSION['user']['id']])
            ->fetchAllAssociative();

        $bookedRides = $this->conn->fetchAllAssociative(
            <<<'SQL'
            SELECT 
                CONCAT(start_nr, " ", start_street, ", ", start_city) AS fullAddressFrom,
                CONCAT(stop_nr, " ", stop_street, ", ", stop_city) AS fullAddressTo,
                price,
                start_city AS fromCity,
                stop_city AS toCity,
                start_time AS time,
                id
            FROM trips as t 
            WHERE t.costumer_id = ? AND (t.status = "claimed" OR t.status = "pending")
            ORDER BY 
                start_time DESC
            SQL, [$_SESSION['user']['id']]

        );
        echo $this->twig->render('pages/account.twig', [
            'loggedIn' => true,
            'user' => [
                'name' => $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'],
                'email' => $_SESSION['user']['email'],
                'status' => $_SESSION['user']['status'],
                'rideAmount' => count($trips),
                'rideHistory' => $trips,
                'bookedRides' => $bookedRides,
                'id' => $userId,
            ],
            'months' => $months
        ]);
    }

    public function search()
    {
        if (!isset($_SESSION['user'])) {
            header('location:/login');
            exit();
        }
        $search = isset($_POST['month']) ? trim($_POST['month']) : '';

        header('location:/account/months/' . urlencode($search));
        exit();
    }

    public function showSearchResults($month)
    {
        $loggedIn = false;
        if (isset($_SESSION['user'])) {
            $loggedIn = true;
        }
        $id = $_SESSION['user']['id'];
        $month = urldecode($month);

        $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];

        $stmt = $this->conn->prepare('SELECT * FROM anonymous_users as anon WHERE anon.id = ?');
        $result = $stmt->executeQuery([$id]);
        $costumer = $result->fetchAssociative();
        if (!$costumer) {
            header('location:/');
            exit();
        }

        $stmt = $this->conn->prepare('SELECT COUNT(*) FROM trips as t WHERE t.costumer_id = ? AND t.status = "finished"');
        $result = $stmt->executeQuery([$id]);
        $tripsCount = $result->fetchOne();

        $matches = array();
        if ($month < 13) {
            $stmt = $this->conn->prepare('SELECT CONCAT(start_nr, " ", start_street, ", ", start_city) AS fullAddressFrom,
                CONCAT(stop_nr, " ", stop_street, ", ", stop_city) AS fullAddressTo,
                price,
                start_city AS fromCity,
                stop_city AS toCity,
                start_time AS time,
                id 
                FROM trips as t WHERE t.costumer_id = ? AND t.status = "finished" AND MONTH(t.start_time) = ?');
            $results = $stmt->executeQuery([$id, $month]);
            $matches = $results->fetchAllAssociative();
        } else {
            header('location:/account');
            exit();
        }

        $bookedRides = $this->conn->fetchAllAssociative(
            <<<'SQL'
            SELECT 
                CONCAT(start_nr, " ", start_street, ", ", start_city) AS fullAddressFrom,
                CONCAT(stop_nr, " ", stop_street, ", ", stop_city) AS fullAddressTo,
                price,
                start_city AS fromCity,
                stop_city AS toCity,
                start_time AS time,
                id
            FROM trips as t 
            WHERE t.costumer_id = ? AND (t.status = "claimed" OR t.status = "pending")
            ORDER BY 
                start_time DESC
            SQL, [$_SESSION['user']['id']]

        );
        echo $this->twig->render('pages/account.twig', [
            'user' => [
                'name' => $costumer['first_name'] . ' ' . $costumer['last_name'],
                'email' => $costumer['email'],
                'status' => 'Rider',
                'rideAmount' => $tripsCount,
                'rideHistory' => $matches,
                'bookedRides' => $bookedRides,
                'id' => $id,
            ],
            'months' => $months,
            'month' => $month,
            'loggedIn' => $loggedIn
        ]);
    }

}
