<?php

namespace Services;

class DatabaseConnector
{
    static function getConnection(string $databaseName = '') : \Doctrine\DBAL\Connection {
        $connectionParams = [
            'url' => 'mysql://' . $_ENV['DB_USER'] . ':' . $_ENV['DB_PASS'] . '@' . $_ENV['DB_HOST'] . '/' . ($databaseName?: $_ENV['DB_NAME'])
        ];

        try {
            $connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
            $connection->connect();
        } catch (\Doctrine\DBAL\Exception $e) {
            if ($_ENV['DEBUG']){
                echo($e->getMessage() . PHP_EOL);
                exit();
            }
            else{
                $filename = __DIR__.'/../../storage/db.log';
                $file = new \SplFileObject($filename,'r');
                $file->fwrite((new \DateTime()) -> format(\DateTimeInterface::RSS).'-'.$e->getMessage() . PHP_EOL);

                header('Location: /unavailable.html');
                exit();
            }
        }
        return $connection;
    }

}