<?php

class TripController
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
    }

    public function showAccountInfo()
    {
        //        if (!isset($_SESSION['user'])) {
        //            header('location: /');
        //            exit();
        //        }

        echo $this->twig->render('pages/account.twig', [
            'User' => [
                'name' => 'Lukas Downes',
                'email' => 'lukasdownes@gmail.com',
                'status' => 'Rider',
                'rideAmount' => 27,
                'rideHistory' => [
                    [
                        'day' => 'Zondag',
                        'time' => 17,
                        'from' => 'Anderlecht',
                        'to' => 'Gent',
                        'date' => '12/12/\'2022',
                        'cost' => 7.63
                    ],
                    [
                        'day' => 'Zondag',
                        'time' => 10,
                        'from' => 'Zaventem',
                        'to' => 'Anderlecht',
                        'date' => '12/12/\'2022',
                        'cost' => 12.9
                    ]
                ]
            ]
        ]);
    }
}