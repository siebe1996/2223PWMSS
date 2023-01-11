<?php

use Services\DatabaseConnector;

class VerificationController
{
    protected $conn;
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
        $verificationCode = isset($_SESSION['flash']['verification']['verificationCode']) ? trim($_SESSION['flash']['verification']['verificationCode']) : (isset($_GET['verificationCode']) ? trim($_GET['verificationCode']) : '');
        $userId = isset($_SESSION['flash']['verification']['userId']) ? trim($_SESSION['flash']['verification']['userId']) : (isset($_GET['userId']) ? trim($_GET['userId']) : '');
        $passwordError = isset($_SESSION['flash']['errors']['password']) ? trim($_SESSION['flash']['errors']['password']) : '';
        $errorMsg = isset($_SESSION['flash']['errors']['main']) ? trim($_SESSION['flash']['errors']['main']) : '';

        unset($_SESSION['flash']['errors']);

        $showPassword = isset($errorMsg) && $errorMsg == '';


        if ($verificationCode !== '' && $userId !== '') {
            $stmt = $this->conn->prepare('SELECT verification_code,verified FROM users WHERE id = ?');
            $result = $stmt->executeQuery([$userId]);
            $user = $result->fetchAssociative();

            if (empty($user)) {
                $errorMsg = 'Geen gebruiker gevonden';
            } elseif ($user['verified'] == 1) {
                $errorMsg = 'Je bent al geverifieerd';
            } else {
                $showPassword = true;
            }
        } else {
            $errorMsg = 'Controlleer je email en veverifieer je account';
        }

        echo $this->twig->render('pages/verification.twig', [
            'errorMsg' => $errorMsg,
            'showPassword' => $showPassword,
            'passwordError' => $passwordError,
            'verificationCode' => $verificationCode,
            'userId' => $userId,
            'user' => [
                'status' => $_SESSION['user']['status'] ?? 'Rider'
            ]
        ]);
    }

    public function verification()
    {
        $verificationCode = isset($_POST['verificationCode']) ? trim($_POST['verificationCode']) : '';
        $userId = isset($_POST['userId']) ? trim($_POST['userId']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        $_SESSION['flash']['verification']['verificationCode'] = $verificationCode;
        $_SESSION['flash']['verification']['userId'] = $userId;

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&]).{8,16}$/', $password)) {
            $_SESSION['flash']['errors']['password'] = 'Je wachtwoord voldoet niet aan alle voorwaarden';
            header('location:verification');
            exit;
        }

        if ($verificationCode !== '' && $userId !== '') {
            $stmt = $this->conn->prepare('SELECT verification_code,verified FROM users WHERE id = ?');
            $result = $stmt->executeQuery([$userId]);
            $user = $result->fetchAssociative();

            if (empty($user)) {
                $_SESSION['flash']['errors']['main'] = 'Geen gebruiker gevonden';
                header('location:verification');
                exit;
            } elseif ($user['verified'] == 1) {
                $_SESSION['flash']['errors']['main'] = 'Geen gebruiker gevonden';
                header('location:verification');
                exit;
            } elseif ($user['verification_code'] == $verificationCode) {
                $stmt = $this->conn->prepare('UPDATE users SET password=?,verified=1 WHERE id = ?;');
                $result = $stmt->executeQuery([password_hash($password, PASSWORD_ARGON2ID), $userId]);
                $user = $result->fetchAssociative();
                header('location:login');
                exit;
            }
        } else {
            $_SESSION['flash']['errors']['main'] = 'Geen gebruiker gevonden';
            header('location:verification');
            exit;
        }
    }
}
