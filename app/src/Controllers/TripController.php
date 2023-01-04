<?php

class TripController
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

    public function showAccountInfo()
    {
        if (!isset($_SESSION['user'])) {
            header('location: /');
            exit();
        }

        echo $this->twig->render('pages/account.twig', [
            'loggedIn' => true,
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

    public function showDriverInfo($id)
    {
        //        if (!isset($_SESSION['user'])) {
        //            header('location: /');
        //            exit();
        //        }

        echo $this->twig->render('pages/account.twig', [
            'User' => [
                'name' => 'Lukas Downes',
                'email' => 'lukasdownes@gmail.com',
                'status' => 'Driver',
                'rideAmount' => 2,
                'rideHistory' => [
                    [
                        'day' => 'Zondag',
                        'time' => 17,
                        'from' => 'Anderlecht',
                        'to' => 'Gent',
                        'date' => '12/12/\'22',
                        'cost' => 7.63
                    ],
                    [
                        'day' => 'Zondag',
                        'time' => 10,
                        'from' => 'Zaventem',
                        'to' => 'Anderlecht',
                        'date' => '12/12/\'22',
                        'cost' => 12.9
                    ]
                ]
            ],
            'DriverInfo' => true
        ]);
    }

    public function showAvailableRides()
    {

        $loggedIn = false;
        if (isset($_SESSION['user'])) {
            $loggedIn = true;
        }
        echo $this->twig->render('pages/availableRides.twig', [
            'loggedIn' => $loggedIn,
            'available' => [
                [
                    'day' => 'Zondag',
                    'time' => 17,
                    'from' => 'Anderlecht',
                    'to' => 'Gent',
                    'date' => '12/12/\'22',
                    'cost' => 7.63,
                    'fullAddressFrom' => 'Henri Vieuxtempsstraat 16, 1070 Anderlecht',
                    'fullAddressTo' => 'Elfjulistraat 46, 9000 Gent'
                ],
                [
                    'day' => 'Zondag',
                    'time' => 10,
                    'from' => 'Zaventem',
                    'to' => 'Anderlecht',
                    'date' => '12/12/\'22',
                    'cost' => 12.9,
                    'fullAddressFrom' => 'Brussels Airport Zaventem',
                    'fullAddressTo' => 'Henri Vieuxtempsstraat 16, 1070 Anderlecht'
                ]
            ],
            'decided' => [
                [
                    'day' => 'Zondag',
                    'time' => 17,
                    'from' => 'Anderlecht',
                    'to' => 'Gent',
                    'date' => '12/12/\'22',
                    'cost' => 7.63,
                    'fullAddressFrom' => 'Henri Vieuxtempsstraat 16, 1070 Anderlecht',
                    'fullAddressTo' => 'Elfjulistraat 46, 9000 Gent'
                ],
                [
                    'day' => 'Zondag',
                    'time' => 10,
                    'from' => 'Zaventem',
                    'to' => 'Anderlecht',
                    'date' => '12/12/\'22',
                    'cost' => 12.9,
                    'fullAddressFrom' => 'Brussels Airport Zaventem',
                    'fullAddressTo' => 'Henri Vieuxtempsstraat 16, 1070 Anderlecht'
                ]
            ]
        ]);
    }
}
