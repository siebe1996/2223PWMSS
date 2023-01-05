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
            return $_ENV['BASE_PATH'] . $path;
        });
        $this->twig->addFunction($function);
    }

    public function showDriverInfo($id)
    {
        //        if (!isset($_SESSION['user'])) {
        //            header('location: /');
        //            exit();
        //        }

        $stmt = $this->conn->prepare('SELECT * FROM anonymous_users as anon JOIN drivers as d on anon.id = d.id WHERE d.id = ?');
        $result = $stmt->executeQuery([$id]);
        $driver = $result->fetchAssociative();
        //als user geen driver is of niet bestaat redirect naar home;
        if(!$driver){
            header('location: /');
            exit();
        }
        var_dump($driver);
        //toDo afwerking met verschillende trips

        echo $this->twig->render('pages/account.twig', [
            'user' => [
                'name' => $driver['first_name'].' '.$driver['last_name'],
                'email' => $driver['email'],
                'gender' => $driver['gender'],
                'car' => $driver['car_brand'],
                'model' => $driver['car_model'],
                'seats' => $driver['car_seats'],
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
            'driverInfo' => true
        ]);
    }

    public function showAvailableRides()
    {

        $loggedIn = false;
        if (isset($_SESSION['user'])) {
            $loggedIn = true;
        }

        $stmt = $this->conn->prepare('SELECT * FROM trips as t WHERE t.driver_id = ?');
        $result = $stmt->executeQuery([$_SESSION['user']['id']]);
        $acceptedRides = $result->fetchAllAssociative();

        $stmt = $this->conn->prepare('SELECT * FROM trips as t WHERE t.status = "pending"');
        $result = $stmt->executeQuery([]);
        $availableRides = $result->fetchAllAssociative();

        echo $this->twig->render('pages/availableRides.twig', [
            'loggedIn' => $loggedIn,
            /*'available' => [
                [
                    'day' => 'Zondag',
                    'when' => 17,
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
            ],*/
            'available' => $availableRides,
            'decided' => $acceptedRides,
        ]);
    }
}
