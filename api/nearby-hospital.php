<?php

function findNearbyHospitals($latitude, $longitude, $radius = 1000) {

    $apiKey = 'AIzaSyAI62cBZ4Y7BhJRRlUfRVU7G2eQ4y4bNQA';
    
    $url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?';
    
    $params = [
        'location' => $latitude . ',' . $longitude,
        'radius' => $radius,
        'type' => 'hospital',
        'keyword' => 'hospital',
        'key' => $apiKey
    ];
    
    $requestUrl = $url . http_build_query($params);
    
    $response = file_get_contents($requestUrl);
    
    $data = json_decode($response, true);
    
    if ($data['status'] === 'OK') {
        return $data['results'];
    } elseif ($data['status'] === 'REQUEST_DENIED') {
        echo "Error: " . $data['error_message'];
    } else {
        echo "Error: " . $data['status'];
    }
}
?>