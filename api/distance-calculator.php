<?php
    function getDistance($lat1,$lon1,$lat2,$lon2){
        $theta = (float)$lon1 - (float)$lon2;
        $dist = sin(deg2rad((float)$lat1)) * sin(deg2rad((float)$lat2)) +  cos(deg2rad((float)$lat1)) * cos(deg2rad((float)$lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $km = $dist * 60 * 1.1515 * 1.609344;

        return $km;
    }
?>