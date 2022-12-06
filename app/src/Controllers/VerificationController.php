<?php
//namespace Controllers;
use Services\DatabaseConnector;
//require_once ('../../vendor/autoload.php');
//require_once ('../../config/database.php');
//require_once ('../../src/Services/DatabaseConnector.php');

class VerificationController
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
    }

    public function show()
    {
        $verificationCode = isset($_GET['verificationCode']) ? $_GET['verificationCode'] : '';
        $userId = isset($_GET['userId']) ? $_GET['userId'] : '';

        $errorMsg = [];

        if (trim($verificationCode) !== '' && trim($userId) !== '') {
            $stmt = $this->conn->prepare('SELECT verification_code,verified FROM users WHERE id = ?');
            $result = $stmt->executeQuery([$userId]);
            $user = $result->fetchAssociative();
            $dbVerificationCode = $user['verification_code'];
            if ($user['verified'] == 1) {
                array_push($errorMsg, 'Je bent al geverifieerd');
            } else if ($dbVerificationCode === $verificationCode) {
                $stmt = $this->conn->prepare('UPDATE users SET verified=1 WHERE id = ?');
                $result = $stmt->executeStatement([$userId]);
                echo 'email geverifieerd';
            } else {
                array_push($errorMsg, 'Er liep iets fout, vraag bij [account > verifieer je email] een nieuwe email aan');
            }
        } else {
            header('location: login');
            exit();
        }
        echo $this->twig->render('pages/verification.twig', [
            'errorMsg' => $errorMsg
        ]);
    }
}

