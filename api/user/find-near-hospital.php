<?php
include("import.php");
include("../nearby-hospital.php");

if(!empty($data->pickup_latitude) && !empty($data->pickup_longitude)){

    $pickup_latitude = $data->pickup_latitude;
    $pickup_longitude = $data->pickup_longitude;

    $hospitals = findNearbyHospitals($pickup_latitude, $pickup_longitude);
    
    if (!empty($hospitals)) {
        foreach ($hospitals as $key=>$hospital) {

            $output_array["GTS"][$key]['name'] = $hospital['name'];
            $output_array["GTS"][$key]['address'] = $hospital['vicinity'];
            $output_array["GTS"][$key]['lat'] = $hospital['geometry']['location']['lat'];
            $output_array["GTS"][$key]['long'] = $hospital['geometry']['location']['lng'];
            
        }
    } else {
        http_response_code(400);
	    $output_array['status'] = false;
	    $output_array['message'] = "No hospitals found nearby.";
    }
}else{
	http_response_code(400);
	$output_array['status'] = false;
	$output_array['message'] = "Bad request";
}

echo json_encode($output_array);
?>