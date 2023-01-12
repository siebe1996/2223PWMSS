<?php

namespace Services;


use Exception;

class ShortestPathService
{
    public static function route(array $startCoords, array $endCoords)
    {
        $route = new \OSRM\Service\Route();
        try {
            $response = $route
                ->fetch(implode(',', $startCoords) . ';' . implode(',', $endCoords));
            if ($response->isOK()) {
                return $response->toArray();
            } else {
                return [];
            }
        } catch (\OSRM\Exception|Exception $e) {
            return [$e];
        }
    }

}