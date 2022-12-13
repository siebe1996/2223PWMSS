<?php

namespace Services;

use maxh\Nominatim\Nominatim;

class LonLatService
{
    public static function search(string $adress, string $zip, string $city)
    {
        $url = "http://nominatim.openstreetmap.org/";
        $nominatim = new Nominatim($url);

        $search = $nominatim->newSearch()
            ->city($city)
            ->postalCode($zip)
            ->addressDetails($adress);

        $search = $nominatim->newSearch();
        $search->query($adress);


        $result = $nominatim->find($search);

        if (isset($result[0]['lat']) && isset($result[0]['lon'])) {
            return array(round($result[0]['lat'], 8), round($result[0]['lon'], 8));
        }
        return array(null);
    }
}
