<?php
require_once ('../../vendor/autoload.php');
require_once ('../../config/database.php');

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
$twig = new \Twig\Environment($loader, [
        'cache' => __DIR__ . '/../../storage/cache',
        'auto_reload' => true
    ]
);

session_start();

// already logged in!
if (isset($_SESSION['user'])) {
    $loggedIn = true;
}
else{
    $loggedIn = false;
}

$homePanel = $twig->load('/pages/home.twig');
echo $homePanel->render([
    'loggedIn' => $loggedIn,
]);