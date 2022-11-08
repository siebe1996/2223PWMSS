<?php
require_once ('../../vendor/autoload.php');
require_once ('../../config/database.php');
require_once ('../../src/Services/DatabaseConnector.php');

$conn = \Services\DatabaseConnector::getConnection();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
$twig = new \Twig\Environment($loader, [
        'cache' => __DIR__ . '/../../storage/cache',
        'auto_reload' => true ]
);

$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$formErrors = [];

if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] === 'register')) {
    if (!preg_match("/^[a-zA-Z-' ]*$/",$firstName)){
        $formErrors['firstName'] = 'Voer een geldige voornaam in';
    }

    if (!preg_match("/^[a-zA-Z-' ]*$/",$lastName)){
        $formErrors['lastName'] = 'Voer een geldige achtenaam in';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $formErrors['email'] = 'Voer een geldige email in';
    }

    if (trim($password) === ''){
        $formErrors['password'] = 'Voer een password in';
    }

    //  if no errors: insert values into database

    if (sizeof($formErrors) === 0){
        // @toDO check errors connection
        $stmt = $conn->prepare('INSERT INTO anonymous_users (email, first_name, last_name) VALUES (?, ?, ?)');
        $result = $stmt->executeStatement([$email, $firstName, $lastName]);
        $stmt2 = $conn->prepare('SELECT id FROM anonymous_users WHERE email = ?');
        $result2 = $stmt2->executeQuery([$email]);
        $userId = $result2->fetchOne();
        $stmt3 = $conn->prepare('INSERT INTO users (id, password) VALUES (?,?)');
        $result3 = $stmt3->executeStatement([$userId, password_hash($password, PASSWORD_DEFAULT)]);

        //toDo redirect to conformation page;
    }
}





$tpl = $twig->load('/pages/register.twig');
echo $tpl->render([
    'firstName' => $firstName,
    'lastName' => $lastName,
    'email' => $email,
    'errors' => $formErrors,
]);