<?php

function findNearbyHospitals($latitude, $longitude) {
    $mapboxAccessToken = 'sk.eyJ1Ijoic2VsdmExNzEwMiIsImEiOiJjbHdqMTgzYnUwc2w3Mm1reGo0bHZtOHRwIn0.ers0JhTLVB2jBXiJc6XM7g';

    // $apiKey = 'AIzaSyAI62cBZ4Y7BhJRRlUfRVU7G2eQ4y4bNQA';
    
    // $url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?';
    
    // $params = [
    //     'location' => $latitude . ',' . $longitude,
    //     'radius' => $radius,
    //     'type' => 'hospital',
    //     'keyword' => 'hospital',
    //     'key' => $apiKey
    // ];
    
    // $requestUrl = $url . http_build_query($params);
    
    // $response = file_get_contents($requestUrl);
    
    // $data = json_decode($response, true);
    
    // if ($data['status'] === 'OK') {
    //     return $data['results'];
    // } elseif ($data['status'] === 'REQUEST_DENIED') {
    //     echo "Error: " . $data['error_message'];
    // } else {
    //     echo "Error: " . $data['status'];
    // }


    $url = "https://api.mapbox.com/geocoding/v5/mapbox.places/hospital.json";
    $params = [
        'proximity' => "$longitude,$latitude",
        'access_token' => $mapboxAccessToken,
        'types' => 'poi',
        'limit' => 10,
    ];
    $query = http_build_query($params);
    $fullUrl = "$url?$query";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        // Print cURL error if any
        echo 'Curl error: ' . curl_error($ch);
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode != 200) {
        // Print HTTP response code for debugging
        echo 'HTTP response code: ' . $httpCode . "\n";
        echo 'Response: ' . $response . "\n";
    }

    curl_close($ch);

    return json_decode($response, true);
}
?>