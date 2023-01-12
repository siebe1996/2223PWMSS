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

    public function confirm($id)
    {
        $tripId = $_POST['accept'] ?? '';

        if ($tripId != $id) {
            header('location:/');
            exit;
        }

        $_SESSION['tripId'] = $tripId;
        header('Location: /driver/rides/' . urlencode($tripId) . '/confirm');
        exit();
    }

    public function showConfirm($id)
    {
        if ($_SESSION['tripId'] != $id) {
            header('location:/');
            exit;
        }

        echo $this->twig->render('pages/acceptRide.twig', [
            'rideId' => $_SESSION['tripId'],
            'loggedIn' => true,
            'user' => $_SESSION['user']
        ]);
    }

    public function acceptRide($id)
    {
        if (isset($_POST['accept']) && $_POST['accept'] == $id) {
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
                    $result = $stmt->executeQuery([$trip['costumer_id']]);
                    $costumer = $result->fetchAssociative();

                    MailService::send(
                        $this->twig,
                        'info@rebu.be',
                        $costumer['email'],
                        'Je rit is geacepteerd',
                        '',
                        'email/acceptatieRide.twig',
                        [
                            'first_name' => $costumer['first_name'],
                            'last_name' => $costumer['last_name'],
                            'trip' => $trip,
                            'driver' => false
                        ]
                    );
                    MailService::send(
                        $this->twig,
                        'info@rebu.be',
                        $_SESSION['user']['email'],
                        'Je hebt een rit geacepteerd',
                        '',
                        'email/acceptatieRide.twig',
                        [
                            'first_name' => $_SESSION['user']['first_name'],
                            'last_name' => $_SESSION['user']['last_name'],
                            'trip' => $trip,
                            'driver' => true
                        ]
                    );

                    header('location:/driver/rides');
                    exit();
                } else {
                    //toDo error ride is claimed
                    header('location:/rideIsClaimed');
                    exit();
                }
            }
        } else {
            unset($_SESSION['tripId']);
            header('location:/');
            exit();
        }
    }

    public function cancelStartFinishRide($id)
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
        if (!trim($tripId) || !trim($userId) || $tripId != $id) {
            header('location:/badrequest');
            exit();
        } else {
            $stmt = $this->conn->prepare('UPDATE trips SET status = ?, driver_id = ? WHERE id = ?');
            $result = $stmt->executeStatement([$status, $userId, $tripId]);

            header('location:/driver/rides');
            exit();
        }
    }

    public function cancel($id)
    {
        if (isset($_POST['cancel'])) {
            $tripId = $_POST['cancel'] ?? '';
        }
        if (!trim($tripId) || $tripId != $id) {
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
