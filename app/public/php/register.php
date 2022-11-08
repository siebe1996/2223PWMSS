<?php
require_once ('../../vendor/autoload.php');

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
$twig = new \Twig\Environment($loader, [
        'cache' => __DIR__ . '/../../storage/cache',
        'auto_reload' => true ]
);
$registerPanel = $twig->load('/pages/register.twig');
echo $registerPanel->render(['pathToRoot'=>'../']);