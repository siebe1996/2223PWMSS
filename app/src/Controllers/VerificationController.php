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
            return BASE_PATH . $path;
        });
        $this->twig->addFunction($function);
    }

    public function show()
    {
        $verificationCode = isset($_GET['verificationCode']) ? $_GET['verificationCode'] : '';
        $userId = isset($_GET['userId']) ? $_GET['userId'] : '';

        $errorMsg = "";
        $allOk = true;

        if (trim($verificationCode) !== '' && trim($userId) !== '') {
            $stmt = $this->conn->prepare('SELECT verification_code,verified FROM users WHERE id = ?');
            $result = $stmt->executeQuery([$userId]);
            $user = $result->fetchAssociative();

            if (empty($user)) {
                $allOk = false;
            }

            if ($allOk) {
                $dbVerificationCode = $user['verification_code'];

                if ($user['verified'] == 1) {
                    $errorMsg = 'Je bent al geverifieerd';
                } else if ($dbVerificationCode === $verificationCode) {
                    $stmt = $this->conn->prepare('UPDATE users SET verified=1 WHERE id = ?');
                    $result = $stmt->executeStatement([$userId]);
                    $errorMsg = 'Je account is succesvol geverifieerd';
                } else {
                    $errorMsg = 'Er liep iets fout, ga naar [account > verifieer je email] en vraag een nieuwe email aan';
                }
            } else {
                $errorMsg = 'Er liep iets fout, ga naar [account > verifieer je email] en vraag een nieuwe email aan';
            }
        } else {
            header('location: login');
            exit();
        }
        echo $this->twig->render('pages/verification.twig', [
            'errorMsg' => $errorMsg,
        ]);
    }
}
