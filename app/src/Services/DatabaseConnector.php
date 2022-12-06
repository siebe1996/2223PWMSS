<?php

namespace Services;

class DatabaseConnector
{
    static function getConnection($DB_NAME = DB_NAME) : \Doctrine\DBAL\Connection {
        $connectionParams = [
            'url' => 'mysql://' . DB_USER . ':' . DB_PASS . '@' . DB_HOST . '/' . $DB_NAME
        ];

        try {
            $connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
            $connection->connect();
        } catch (\Doctrine\DBAL\Exception $e) {
            if (DEBUG){
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