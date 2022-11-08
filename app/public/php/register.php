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

    if(!in_array($priority, $priorities)){
        $formErrors[] = 'Ongeldige prioriteit geselecteerd';
    }

    //  if no errors: insert values into database

    if (sizeof($formErrors) === 0){
        $stmt = $conn->prepare('INSERT INTO tasks (name, priority, added_on) VALUES (?, ?, ?)');
        $result = $stmt->executeStatement([$what, $priority, (new DateTime()) -> format('y-m-d h:i:s')]);
        $what = '';
        $priority = 'low';
    }
}





$registerPanel = $twig->load('/pages/register.twig');
echo $registerPanel->render(['pathToRoot'=>'../']);