<?php

class GeoHelper {
    public static function loadCityCoordinates(string $path): array {
        $json = file_get_contents($path);
        return json_decode($json, true);
    }

    public static function getCoordinatesByCity(array $citiesJson): array {
        $coordinates = [];
        foreach ($citiesJson as $entry) {
            $coordinates[$entry['nom']] = $entry['centre']['coordinates'];
        }
        return $coordinates;
    }

    public static function haversine(float $lat1, float $lon1, float $lat2, float $lon2): float {
        $r = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $r * $c;
    }
}
