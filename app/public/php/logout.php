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
if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'logout')) {
    header('location: login.php');
}

$tpl = $twig->load('pages/logout.twig');
echo $tpl->render();