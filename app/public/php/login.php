<?php

// Composer's autoloader & DB init
require_once ('../../vendor/autoload.php');
require_once ('../../config/database.php');
require_once ('../../src/Services/DatabaseConnector.php');

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
$twig = new \Twig\Environment($loader, [
        'cache' => __DIR__ . '/../../storage/cache',
        'auto_reload' => true ]
);

// start session (starts a new one, or continues the already started one)
session_start();

// already logged in!
if (isset($_SESSION['user'])) {
    header('location: index.php');
    exit();
}

// var to tell if we have a login error
$formErrors = [];

// extract sent in username & password
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'login')) {

    $conn = \Services\DatabaseConnector::getConnection();
    //@toDO handle error
    $user = $conn->fetchAssociative('SELECT anon.id, anon.email, anon.first_name, anon.last_name, u.password, u.verified FROM anonymous_users AS anon WHERE email = ? JOIN users AS u ON anonymous_users.id = users.id', [$email]);

    if ($user !== false) {

        if (password_verify($password, $user['password'])) {

            // Store the user row in the session
            $_SESSION['user'] = $user;
            header('location: index.php');
            exit();
        } // Invalid login
        else {
            $formErrors[] = 'Invalid login credentials';
        }
    } // username & password are not valid
    else {
        $formErrors[] = 'Invalid login credentials';
    }

}

$tpl = $twig->load('pages/login.twig');
echo $tpl->render([
    'errors' => $formErrors,
]);

