<?php

namespace Services;

use maxh\Nominatim\Nominatim;

class LonLatService
{
    public static function search(string $address)
    {
        $url = "http://nominatim.openstreetmap.org/";
        $nominatim = new Nominatim($url);

        $search = $nominatim->newSearch()
            ->query($address);


        $result = $nominatim->find($search);

        if (isset($result[0]['lat']) && isset($result[0]['lon'])) {
            return array(round($result[0]['lon'], 6), round($result[0]['lat'], 6));
        }
        return array(null);
    }
}
