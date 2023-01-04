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
            return BASE_PATH . $path;
        });
        $this->twig->addFunction($function);
    }

    public function showLogin()
    {
        $formErrors = isset($_SESSION['flash']['errors']['login']) ? trim($_SESSION['flash']['errors']['login']) : '';
        //$email = isset($_SESSION['flash']['login']['email']) ? trim($_SESSION['flash']['login']['email']) :  '';
        //$password = isset($_SESSION['flash']['login']['password']) ? trim($_SESSION['flash']['login']['password']) :  '';
        unset($_SESSION['flash']);

        echo $this->twig->render('pages/login.twig', [
            'error' => $formErrors,
            'disappearingSVG' => true,
            'loggedIn' => false,
        ]);
    }

    public function login()
    {
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        $allOk = true;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $formErrors = 'Please enter valid credentials';
            $allOk = false;
        }
        if ($password === '') {
            $formErrors = 'Please enter valid credentials';
            $allOk = false;
        }

        if (!$allOk) {
            $_SESSION['flash']['errors'] = ['login' => $formErrors];
            header('Location: login');
            exit();
        }
        $user = $this->conn->fetchAssociative('SELECT anon.id, anon.email, anon.first_name, anon.last_name, u.password, u.verified FROM anonymous_users AS anon, users AS u WHERE email = ? AND anon.id = u.id/*JOIN users AS u ON anonymous_users.id = users.id*/', [$email]);


        if ($user !== false) {
            if ($user['verified']) {
                if (password_verify($password, $user['password'])) {
                    // Store the user row in the session
                    $_SESSION['user'] = $user;
                    header('Location: ..');
                    exit();
                } // Invalid login
                else {
                    $formErrors = 'Please enter valid credentials';
                    $_SESSION['flash']['errors'] = ['login' => $formErrors];
                    header('Location: login');
                    exit();
                }
            } else {
                $formErrors = 'Please validate user';
                $_SESSION['flash']['errors'] = ['login' => $formErrors];
                header('Location: login');
                exit();
            }
        } // username & password are not valid
        else {
            $formErrors = 'Please enter valid credentials';
            $_SESSION['flash']['errors'] = ['login' => $formErrors];
            header('Location : login');
            exit();
        }
    }

    public function showRegister()
    {
        $firstName = isset($_SESSION['flash']['register']['firstName']) ? trim($_SESSION['flash']['register']['firstName']) : '';
        $lastName = isset($_SESSION['flash']['register']['lastName']) ? trim($_SESSION['flash']['register']['lastName']) : '';
        $email = isset($_SESSION['flash']['register']['email']) ? trim($_SESSION['flash']['register']['email']) : '';
        //$password = isset($_SESSION['flash']['register']['password']) ? trim($_SESSION['flash']['register']['password']) : '';
        $formErrors = isset($_SESSION['flash']['errors']['register']) ? $_SESSION['flash']['errors']['register'] : '';
        unset($_SESSION['flash']);
        echo $this->twig->render('pages/register.twig', [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'errors' => $formErrors,
            'loggedIn' => false,
        ]);
    }

    public function Register()
    {
        $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
        $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        //$password = isset($_POST['password']) ? $_POST['password'] : '';
        $formErrors = [];

        $allOk = true;

        if (trim($firstName) === '') {
            $formErrors['firstName'] = 'Voer een voornaam in';
            $allOk = false;
        } else if (!preg_match("/^[a-zA-Z-' ]+$/", $firstName)) {
            $formErrors['firstName'] = 'Voer een geldige voornaam in';
            $allOk = false;
        }

        if (trim($lastName) === '') {
            $formErrors['lastName'] = 'Voer een achternaam in';
            $allOk = false;
        } else if (!preg_match("/^[a-zA-Z-' ]+$/", $lastName)) {
            $formErrors['lastName'] = 'Voer een geldige achternaam in';
            $allOk = false;
        }

        if (trim($email) === '') {
            $formErrors['email'] = 'Voer een email in';
            $allOk = false;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $formErrors['email'] = 'Voer een geldige email in';
            $allOk = false;
        } else {
            $stmt = $this->conn->prepare('SELECT * FROM anonymous_users WHERE email = ?');
            $result = $stmt->executeQuery([$email]);
            $anonymous_user = $result->fetchAssociative();

            if (!empty($anonymous_user)) {
                $formErrors['email'] = 'Er bestaat al een gebruiker met dit e-mailadres';
                $allOk = false;
            }
        }

        if (!$allOk) {
            $register = ['firstName' => $firstName, 'lastName' => $lastName, 'email' => $email];
            $_SESSION['flash']['register'] = $register;
            $_SESSION['flash']['errors'] = ['register' => $formErrors];
            header('location:register');
            exit;
        }

        // @toDO check errors connection
        $verificationCode = substr(str_shuffle(implode(range('A', 'Z'))), 0, 16);

        $stmt = $this->conn->prepare('INSERT INTO anonymous_users (email, first_name, last_name) VALUES (?, ?, ?)');
        $result = $stmt->executeStatement([$email, $firstName, $lastName]);
        $stmt2 = $this->conn->prepare('SELECT id FROM anonymous_users WHERE email = ?');
        $result2 = $stmt2->executeQuery([$email]);
        $userId = $result2->fetchOne();
        $stmt3 = $this->conn->prepare('INSERT INTO users (id, verification_code) VALUES (?,?)');
        $result3 = $stmt3->executeStatement([$userId, $verificationCode]);
        //$user = $this->conn->fetchAssociative('SELECT anon.id, anon.email, anon.first_name, anon.last_name, u.password, u.verified FROM anonymous_users AS anon, users AS u WHERE email = ? AND anon.id = u.id/*JOIN users AS u ON anonymous_users.id = users.id*/', [$email]);
        //$_SESSION['user'] = $user;

        MailService::send($this->twig, 'info@rebu.be', $email, 'Verifieer je account', 'Je verificatiecode is: ' . $verificationCode, 'email/verificatiecode.twig', [
            'verificationCode' => $verificationCode,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'userId' => $userId
        ]);
        //toDo redirect to conformation page;

        header('location:..');
        exit();
    }

    public function logout()
    {
        session_destroy();

        header('Location: login');
        exit();
    }
}
