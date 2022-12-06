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

    public function showAll()
    {
        if (!isset($_SESSION['user'])) {
            header('location: /labo08/login');
            exit();
        }
        $results = $this->conn->fetchAllAssociative('SELECT c.id, c.name, c.address, c.postal_code, c.city, c.vat_number, con.first_name, con.last_name FROM companies AS c LEFT JOIN contacts AS con ON c.id = con.company_id WHERE con.primary_contact = true', []);
        echo $this->twig->render('companies08.twig', ['results' => $results,]);
    }

    public function show($term)
    {
        $search = urldecode($term);
        $searchArr = explode(' ', $search);
        $collection = array();
        foreach ($searchArr as $searchTerm) {
            $stmt = $this->conn->prepare('SELECT c.id, c.name, c.address, c.postal_code, c.city, c.vat_number, con.first_name, con.last_name FROM companies AS c LEFT JOIN contacts AS con ON c.id = con.company_id WHERE con.primary_contact = true AND (c.id LIKE ? OR c.name LIKE ? OR c.address LIKE ? OR c.postal_code LIKE ? OR c.city LIKE ? OR c.vat_number LIKE ? OR con.first_name LIKE ? OR con.last_name LIKE ?)');
            $results = $stmt->executeQuery(['%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%']);
            $results = $results->fetchAllAssociative();
            $collection = array_merge($collection, $results);
        }
        $matches = array_unique($collection, SORT_REGULAR);
        if (count($matches) < 1) {
            $matches[0]['name'] = 'Geen overeenkomsten gevonden';
        }
        $_SESSION['flash'] = ['search' => $search];
        $session = $_SESSION;
        echo $this->twig->render('companies08.twig', ['results' => $matches, 'session' => $session]);
    }

    public function showResults()
    {
        if (!isset($_SESSION['user'])) {
            header('location: /labo08/login');
            exit();
        }
        $search = isset($_POST['search']) ? trim($_POST['search']) : '';
        //

        header('Location: search/' . urlencode($search));
        exit();

        //
        /*
        $searchArr = explode(' ', $search);
        $collection = array();
        foreach ($searchArr as $searchTerm) {
            $stmt = $this->conn->prepare('SELECT c.id, c.name, c.address, c.postal_code, c.city, c.vat_number, con.first_name, con.last_name FROM companies AS c LEFT JOIN contacts AS con ON c.id = con.company_id WHERE con.primary_contact = true AND (c.id LIKE ? OR c.name LIKE ? OR c.address LIKE ? OR c.postal_code LIKE ? OR c.city LIKE ? OR c.vat_number LIKE ? OR con.first_name LIKE ? OR con.last_name LIKE ?)');
            $results = $stmt->executeQuery(['%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%']);
            $results = $results->fetchAllAssociative();
            $collection = array_merge($collection, $results);
        }
        $matches = array_unique($collection, SORT_REGULAR);
        if (count($matches) < 1) {
            $matches[0]['name'] = 'Geen overeenkomsten gevonden';
        }
        $_SESSION['flash'] = ['search' => $search];
        $session = $_SESSION;
        echo $this->twig->render('companies08.twig', ['results' => $matches, 'session' => $session]);
        */
    }

    public function form()
    {
        if (!isset($_SESSION['user'])) {
            header('location: /labo08/login');
            exit();
        }
        //$contacts = $this->conn->fetchAllAssociative('SELECT c.id, c.first_name, c.last_name FROM contacts AS c', []);
        $_SESSION['flash']['form'] = '';
        $_SESSION['flash']['errors'] = '';
        echo $this->twig->render('form08.twig', ['session' => $_SESSION]);
    }

    public function add()
    {
        if (!isset($_SESSION['user'])) {
            header('location: /labo08/login');
            exit();
        }
        /*$contacts = $this->conn->fetchAllAssociative('SELECT id FROM contacts', []);
        $contactsIds = [];
        foreach ($contacts as $contact){
            $contactsIds[] = $contact['id'];
        }*/
        $existingVatNumbers = $this->conn->fetchAllAssociative('SELECT vat_number FROM companies', []);
        $existingVatNumbersArr = [];
        foreach ($existingVatNumbers as $existingVatNumber) {
            $existingVatNumbersArr[] = $existingVatNumber['vat_number'];
        }
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $vatNumber = isset($_POST['vat_number']) ? trim($_POST['vat_number']) : '';
        $address = isset($_POST['address']) ? trim($_POST['address']) : '';
        $zip = isset($_POST['zip']) ? trim($_POST['zip']) : '';
        $city = isset($_POST['city']) ? trim($_POST['city']) : '';
        //$primaryContactId = isset($_POST['primary_contact']) ? trim($_POST['primary_contact']) : '';
        $primaryContactFirstName = isset($_POST['primary_contact_first_name']) ? trim($_POST['primary_contact_first_name']) : '';
        $primaryContactLastName = isset($_POST['primary_contact_last_name']) ? trim($_POST['primary_contact_last_name']) : '';
        $primaryContactEmail = isset($_POST['primary_contact_email']) ? trim($_POST['primary_contact_email']) : '';
        $primaryContactPhone = isset($_POST['primary_contact_phone']) ? trim($_POST['primary_contact_phone']) : '';

        $formErrors = [];
        if (!preg_match("/^[a-zA-Z-' ]+$/", $name)) {
            $formErrors['name'] = 'Fill in company name';
        }
        /*if (!preg_match("/^[A-Za-z]{2,4}(?=.{2,12}$)[-_\s0-9]*(?:[a-zA-Z][-_\s0-9]*){0,2}$/", $vatNumber)){
            $formErrors['vat_number'] = 'Fill in vat number';
        }*/
        if (!preg_match("/^BE[0-9]{4}\.[0-9]{3}\.[0-9]{3}$/", $vatNumber) || in_array($vatNumber, $existingVatNumbersArr)) {
            $formErrors['vat_number'] = 'Fill in vat number';
        }
        if (!$address) {
            $formErrors['address'] = 'Fill in address';
        }
        if (!$zip) {
            $formErrors['zip'] = 'Fill in zip';
        }
        if (!preg_match("/^[a-zA-Z- ']+$/", $city)) {
            $formErrors['city'] = 'Fill in city';
        }
        /*if (!in_array((int)$primaryContactId, $contactsIds)){
            $formErrors['primary_contact'] = 'Select a contact';
        }*/
        if (!preg_match("/^[a-zA-Z-' ]+$/", $primaryContactFirstName)) {
            $formErrors['primary_contact_first_name'] = 'Fill in first name';
        }
        if (!preg_match("/^[a-zA-Z-' ]+$/", $primaryContactLastName)) {
            $formErrors['primary_contact_last_name'] = 'Fill in last name';
        }
        if (!filter_var($primaryContactEmail, FILTER_VALIDATE_EMAIL)) {
            $formErrors['primary_contact_email'] = 'Fill in email';
        }
        if (!preg_match('/^[0-9]{10}$/', $primaryContactPhone)) {
            $formErrors['primary_contact_phone'] = 'Fill in phone';
        }
        if (!$formErrors) {
            $stmt = $this->conn->prepare('INSERT INTO companies (name, address, postal_code, city, vat_number) VALUES (?, ?, ?, ?, ?)');
            $result = $stmt->executeStatement([$name, $address, $zip, $city, $vatNumber]);
            $companyId = $this->conn->fetchOne('SELECT LAST_INSERT_ID()', []);
            $stmt2 = $this->conn->prepare('INSERT INTO contacts (company_id, primary_contact, first_name, last_name, email, phone) VALUES (?, ?, ?, ?, ?, ?)');
            $result2 = $stmt2->executeStatement([$companyId, true, $primaryContactFirstName, $primaryContactLastName, $primaryContactEmail, $primaryContactPhone]);
            header('Location: ../companies');
            exit();
        }
        $form = ['name' => $name, 'vat_number' => $vatNumber, 'address' => $address, 'zip' => $zip, 'city' => $city, 'primary_contact_first_name' => $primaryContactFirstName, 'primary_contact_last_name' => $primaryContactLastName, 'primary_contact_email' => $primaryContactEmail, 'primary_contact_phone' => $primaryContactPhone];
        $_SESSION['flash'] = ['errors' => $formErrors, 'form' => $form];
        echo $this->twig->render('form08.twig', ['session' => $_SESSION]);
    }

    public function showLogin()
    {
        if (isset($_SESSION['user'])) {
            header('location: /labo08/companies');
            exit();
        }
        echo $this->twig->render('login08.twig', ['session' => $_SESSION]);
    }

    public function login()
    {
        if (isset($_SESSION['user'])) {
            header('location: /labo08/companies');
            exit();
        }
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $user = $this->conn->fetchAssociative('SELECT * FROM users WHERE username = ?', [$username]);

        if ($user !== false) {

            if($user['verified']) {
                if (password_verify($password, $user['password'])) {

                    // Store the user row in the session
                    $_SESSION['user'] = $user;
                    $_SESSION['flash']['errors'] = '';
                    header('Location: /labo08/companies');
                    exit();
                } // Invalid login
                else {
                    $formErrors['login'] = 'Please enter valid credentials';
                    $_SESSION['flash'] = ['errors' => $formErrors];
                    echo $this->twig->render('login08.twig', ['session' => $_SESSION]);
                }
            }
            else{
                $formErrors['login'] = 'Please validate user';
                $_SESSION['flash'] = ['errors' => $formErrors];
                echo $this->twig->render('login08.twig', ['session' => $_SESSION]);

            }
        } // username & password are not valid
        else {
            $formErrors['login'] = 'Please enter valid credentials';
            $_SESSION['flash'] = ['errors' => $formErrors];
            echo $this->twig->render('login08.twig', ['session' => $_SESSION]);
        }
    }

    public function logout()
    {
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
        header('location: /labo08/login');
        exit();
    }

    public function Register()
    {
        if (isset($_SESSION['user'])) {
            header('location: /labo08/companies');
            exit();
        }
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $formErrors = [];
        if (!preg_match("/^[a-zA-Z-' ]+$/",$username)){
            $formErrors['register_user'] = 'Fill in username';
        }

        if (!$password){
            $formErrors['register_password'] = 'Fill in password';
        }

        $user = $this->conn->fetchAssociative('SELECT * FROM users WHERE username = ?', [$username]);

        if ($user !== false) {
            $formErrors['register_exists'] = 'This user already exists';
        }

        //  if no errors: insert values into database

        if (!$formErrors){
            // @toDO check errors connection
            $stmt = $this->conn->prepare('INSERT INTO users (username, password, role_id, added_on) VALUES (?, ?, ?, ?)');
            $result = $stmt->executeStatement([$username, password_hash($password, PASSWORD_DEFAULT), 2, (new DateTime()) -> format('y-m-d h:i:s')]);
            //$user = $this->conn->fetchAssociative('SELECT * FROM users WHERE username = ?', [$username]);
            $_SESSION['flash']['errors'] = '';
            $_SESSION['flash']['register'] ='';
            header('location: /labo08/companies');
            exit();

            //toDo redirect to conformation page;
        }
        $register = ['username' => $username, 'password' => $password];
        $_SESSION['flash'] = ['errors' => $formErrors, 'register' => $register];
        header('Location: /labo08/login#signup');
        exit();
    }

    public function test()
    {
        $contents = isset($_POST['message']) ? trim($_POST['message']) : '';

        if (strlen($contents) < 3) {
            $formErrors[] = '';
        }

        if (!$formErrors) {
            $stmt = $this->db->prepare('INSERT INTO messages (message, user_id) VALUES (?, ?)');
            $stmt->executeStatement([$contents, $_SESSION['user']['id']]);
            header('Location: ../messages');
            exit();
        }
        $_SESSION['flash'] = ['errors' => $formErrors, 'contents' => $contents];
        header('Location: create');
        exit();
    }
}
