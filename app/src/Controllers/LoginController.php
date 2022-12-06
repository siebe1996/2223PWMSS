<?php
//namespace Controllers;
use Services\DatabaseConnector;

class LoginController
{
    protected \Doctrine\DBAL\Connection $db;
    protected \Twig\Environment $twig;

    public function __construct()
    {
        // initiate DB connection
        $this->conn = \Services\DatabaseConnector::getConnection('helpdesk');

        // bootstrap Twig
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
        $this->twig = new \Twig\Environment($loader);
        $function = new \Twig\TwigFunction('url', function ($path) {
            return BASE_PATH . $path;
        });
        $this->twig->addFunction($function);
        //start session
        session_start();
    }

    public function show()
    {
        if (isset($_SESSION['user'])) {
            header('location: /labo08/companies');
            exit();
        }
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
        if (isset($_SESSION['user'])) {
            header('location: /labo08/companies');
            exit();
        }
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $user = $this->conn->fetchAssociative('SELECT anon.id, anon.email, anon.first_name, anon.last_name, u.password, u.verified FROM anonymous_users AS anon, users AS u WHERE email = ? AND anon.id = u.id/*JOIN users AS u ON anonymous_users.id = users.id*/', [$email]);


        if ($user !== false) {

            if($user['verified']) {
                if (password_verify($password, $user['password'])) {

                    // Store the user row in the session
                    $_SESSION['user'] = $user;
                    $_SESSION['flash']['errors'] = '';
                    header('Location: /');
                    exit();
                } // Invalid login
                else {
                    $formErrors = 'Please enter valid credentials';
                    $_SESSION['flash'] = ['errors' => $formErrors];
                    echo $this->twig->render('login08.twig', ['session' => $_SESSION]);
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
}
