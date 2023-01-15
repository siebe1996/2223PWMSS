<?php

class ErrorController
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

    public function notFound(){
        header('HTTP/1.1 404 Not Found');
        http_response_code(404);
        echo $this->twig->render('errors/404.twig', [
        ]);
    }

    public function badRequest(){
        header('HTTP/1.1 400 Not Found');
        http_response_code(400);
        echo $this->twig->render('errors/400.twig', [
        ]);
    }
}