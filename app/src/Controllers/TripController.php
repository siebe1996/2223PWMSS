<?php

use Services\MailService;

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

    public function showAvailableRides()
    {

        $loggedIn = false;
        if (isset($_SESSION['user'])) {
            $loggedIn = true;
        }

        $acceptedRides = $this->conn->fetchAllAssociative(
            <<<'SQL'
            SELECT 
                CONCAT(start_nr, " ", start_street, ", ", start_city) AS fullAddressFrom,
                CONCAT(stop_nr, " ", stop_street, ", ", stop_city) AS fullAddressTo,
                price,
                start_city AS fromCity,
                stop_city AS toCity,
                start_time AS time,
                id,
                status
            FROM trips as t 
            WHERE t.driver_id = ? AND (t.status = "claimed" OR t.status = "started")
            ORDER BY t.start_time
            SQL,
            [$_SESSION['user']['id']]
        );

        $availableRides = $this->conn->fetchAllAssociative(
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
            WHERE t.status = "pending"
            ORDER BY t.start_time
            SQL
        );

        echo $this->twig->render('pages/availableRides.twig', [
            'loggedIn' => $loggedIn,
            'available' => $availableRides,
            'decided' => $acceptedRides,
            'user' => [
                'status' => $_SESSION['user']['status'] ?? 'Rider'
            ]
        ]);
    }

    public function confirm(){
        $tripId = $_POST['accept'] ?? '';
        $_SESSION['tripId'] = $tripId;
        header('Location: /driver/rides/'. urlencode($tripId) .'/confirm');
        exit();
    }

    public function showConfirm(){
        echo $this->twig->render('pages/acceptRide.twig', [
            'rideId' => $_SESSION['tripId'],
        ]);
    }

    public function acceptRide()
    {
        if (isset($_POST['accept'])){
            $userId = $_SESSION['user']['id'];
            $tripId = $_SESSION['tripId'] ?? '';
            unset($_SESSION['tripId']);
            if (!trim($tripId) || !trim($userId)) {
                //toDo denk hierover na
                header('location:/badrequest');
                exit();
            } else {
                $stmt = $this->conn->prepare('SELECT * FROM trips WHERE status = ? AND id = ?');
                $result = $stmt->executeQuery(['pending', $tripId]);
                $trip = $result->fetchAssociative();
                if ($trip) {
                    $stmt = $this->conn->prepare('UPDATE trips SET status = ?, driver_id = ? WHERE id = ?');
                    $result = $stmt->executeStatement(['claimed', $userId, $tripId]);

                    $stmt = $this->conn->prepare('SELECT * FROM anonymous_users WHERE id = ?');
                    $result = $stmt->executeQuery([$userId]);
                    $driver = $result->fetchAssociative();
                    var_dump($driver);
                    MailService::send(
                        $this->twig,
                        'info@rebu.be',
                        $driver['email'],
                        'Je hebt een rit geacepteerd',
                        '',
                        'email/acceptRide',
                        [
                            'first_name' => $driver['first_name'],
                            'last_name' => $driver['last_name'],
                            'trip' => $trip,
                            'driver' => true
                        ]
                    );
                    MailService::send(
                        $this->twig,
                        'info@rebu.be',
                        $_SESSION['user']['email'],
                        'Je rit is geacepteerd',
                        '',
                        'email/acceptRide',
                        [
                            'first_name' => $_SESSION['user']['first_name'],
                            'last_name' => $_SESSION['user']['last_name'],
                            'trip' => $trip,
                            'driver' => false
                        ]
                    );

                    header('location:driver/rides');
                    exit();
                }else{
                    //toDo error raide is claimed
                    header('location:/rideIsClaimed');
                    exit();
                }
            }
        }
        else{
            unset($_SESSION['tripId']);
            header('location:/');
            exit();
        }
    }

    public function cancelStartFinishRide()
    {
        $userId = $_SESSION['user']['id'];
        $status = 'pending';
        if (isset($_POST['cancel'])) {
            $tripId = $_POST['cancel'] ?? '';
        } elseif (isset($_POST['finish'])) {
            $tripId = $_POST['finish'] ?? '';
            $status = 'finished';
        } elseif (isset($_POST['start'])) {
            $tripId = $_POST['start'] ?? '';
            $status = 'started';
        }
        if (!trim($tripId) || !trim($userId)) {
            header('location:/badrequest');
            exit();
        } else {
            $stmt = $this->conn->prepare('UPDATE trips SET status = ?, driver_id = ? WHERE id = ?');
            $result = $stmt->executeStatement([$status, $userId, $tripId]);

            header('location:/driver/rides');
            exit();
        }
    }

    public function cancel()
    {
        if (isset($_POST['cancel'])) {
            $tripId = $_POST['cancel'] ?? '';
        }
        if (!trim($tripId)){
            header('location:/badrequest');
            exit();
        } else {
            $stmt = $this->conn->prepare('UPDATE trips SET status =  "cancelled" WHERE id = ?');
            $result = $stmt->executeStatement([$tripId]);

            header('location:/users');
            exit();
        }
    }
}
