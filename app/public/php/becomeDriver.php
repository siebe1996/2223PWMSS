<?php
require_once ('../../vendor/autoload.php');
require_once ('../../config/database.php');

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__ . '/../../storage/cache',
    'auto_reload' => true
    ]
);

$becomeDriverPanel = $twig->load('/pages/becomeDriver.twig');
echo $becomeDriverPanel->render(['pathToRoot'=>'../','driverRegister'=>true]);