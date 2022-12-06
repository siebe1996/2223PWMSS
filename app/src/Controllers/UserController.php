<?php
//namespace Controllers;
use Services\DatabaseConnector;
use PHPMailer\PHPMailer\PHPMailer;
//require_once ('../../vendor/autoload.php');
//require_once ('../../config/database.php');
//require_once ('../../src/Services/DatabaseConnector.php');

class UserController
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
        if (isset($_SESSION['user'])) {
            header('location: /');
            exit();
        }
    }

    public function showLogin()
    {
        $formErrors = isset($_SESSION['flash']['errors']['login']) ? trim($_SESSION['flash']['errors']['login']) :  '';
        //$email = isset($_SESSION['flash']['login']['email']) ? trim($_SESSION['flash']['login']['email']) :  '';
        //$password = isset($_SESSION['flash']['login']['password']) ? trim($_SESSION['flash']['login']['password']) :  '';
        unset($_SESSION['flash']);

        echo $this->twig->render('pages/login.twig', ['error' => $formErrors,
            'disappearingSVG' => true,
            'loggedIn' => false,]);
    }

    public function login()
    {
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $user = $this->conn->fetchAssociative('SELECT anon.id, anon.email, anon.first_name, anon.last_name, u.password, u.verified FROM anonymous_users AS anon, users AS u WHERE email = ? AND anon.id = u.id/*JOIN users AS u ON anonymous_users.id = users.id*/', [$email]);


        if ($user !== false) {

            if($user['verified']) {
                if (password_verify($password, $user['password'])) {

                    // Store the user row in the session
                    $_SESSION['user'] = $user;
                    header('Location: /');
                    exit();
                } // Invalid login
                else {
                    $formErrors = 'Please enter valid credentials';
                    $_SESSION['flash'] = ['errors' => $formErrors];
                    header('Location : login');
                }
            }
            else{
                $formErrors['login'] = 'Please validate user';
                $_SESSION['flash'] = ['errors' => $formErrors];
                header('Location : login');

            }
        } // username & password are not valid
        else {
            $formErrors['login'] = 'Please enter valid credentials';
            $_SESSION['flash'] = ['errors' => $formErrors];
            header('Location : login');
        }
    }

    public function showRegister(){
        $firstName = isset($_SESSION['flash']['register']['firstName']) ? trim($_SESSION['flash']['register']['firstName']) : '';
        $lastName = isset($_SESSION['flash']['register']['lastName']) ? trim($_SESSION['flash']['register']['lastName']) : '';
        $email = isset($_SESSION['flash']['register']['email']) ? trim($_SESSION['flash']['register']['email']) : '';
        $password = isset($_SESSION['flash']['register']['password']) ? trim($_SESSION['flash']['register']['password']) : '';
        $formErrors = isset($_SESSION['flash']['errors']['register']) ? trim($_SESSION['flash']['errors']['register']) :  '';
        unset($_SESSION['flash']);

        echo $this->twig->render('pages/register.twig', [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'errors' => $formErrors,
            'loggedIn' => false,
            ]);
    }

    public function Register(){

        $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
        $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $formErrors = [];

        if (!preg_match("/^[a-zA-Z-' ]+$/", $firstName)) {
            $formErrors['firstName'] = 'Voer een geldige voornaam in';
        }

        if (!preg_match("/^[a-zA-Z-' ]+$/", $lastName)) {
            $formErrors['lastName'] = 'Voer een geldige achternaam in';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $formErrors['email'] = 'Voer een geldige email in';
        }

        if (trim($password) === '') {
            $formErrors['password'] = 'Voer een password in';
        }

        if (sizeof($formErrors) === 0) {
            // @toDO check errors connection
            $verificationCode = substr(str_shuffle(implode(range('A', 'Z'))), 0, 16);

            $stmt = $this->conn->prepare('INSERT INTO anonymous_users (email, first_name, last_name) VALUES (?, ?, ?)');
            $result = $stmt->executeStatement([$email, $firstName, $lastName]);
            $stmt2 = $this->conn->prepare('SELECT id FROM anonymous_users WHERE email = ?');
            $result2 = $stmt2->executeQuery([$email]);
            $userId = $result2->fetchOne();
            $stmt3 = $this->conn->prepare('INSERT INTO users (id, password, verification_code) VALUES (?,?,?)');
            $result3 = $stmt3->executeStatement([$userId, password_hash($password, PASSWORD_DEFAULT), $verificationCode]);
            $userId = $this->conn->lastInsertId();
            $user = $this->conn->fetchAssociative('SELECT anon.id, anon.email, anon.first_name, anon.last_name, u.password, u.verified FROM anonymous_users AS anon, users AS u WHERE email = ? AND anon.id = u.id/*JOIN users AS u ON anonymous_users.id = users.id*/', [$email]);
            $_SESSION['user'] = $user;

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = 2;
            $mail->Host = 'smtp.mailgun.org';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = 'postmaster@sandbox3341d6d8775c4d6d93839c2ec65b7741.mailgun.org';
            $mail->Password = 'fd5f7e5f1208a625129e67b59d3c343f-f2340574-9cd32674';
            $mail->setFrom('postmaster@sandbox3341d6d8775c4d6d93839c2ec65b7741.mailgun.org', 'Rebu');
            $mail->addAddress($email, $firstName . ' ' . $lastName);
            $mail->Subject = 'Verifieer je email';
            $mail->Body = 'Klink op de link en <a href="http://localhost:8080/verification.php?verificationCode=' . $verificationCode . '&userId=' . $userId . '">verifieer je email</a>.';
            if ($mail->send()) {
                header('location: /');
                exit();
            } else {
                echo 'mail versturen gefaald';
            }


            //toDo redirect to conformation page;
        }
        else {
            $_SESSION['flash']['errors'] = ['register' => $formErrors];
            header('Location : login');
        }
    }

    public function logout(){
        // Unset all of the session variables.
        $_SESSION = [];

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();

        // redirect to index
        header('location: login');
        exit();
    }
}
