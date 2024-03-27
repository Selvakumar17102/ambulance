<?php
	include("import.php");

	if(!empty($data->latitude) && !empty($data->longitude)){
		// $city_id = $data->city_id;
		$lat = $data->latitude;
		$long = $data->longitude;

		$sql = "SELECT * FROM blood_bank";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
            $i = 0; 
            while($row = $result->fetch_assoc()){

				$reqlat = $row['blood_bank_latitude'];
                $reqlong = $row['blood_bank_longitude'];

				$appsql = "SELECT * FROM `blood_app_control`";
                $appResult = $conn->query($appsql);
                $approw =$appResult->fetch_assoc();

				$km = round(getDistance($lat,$long,$reqlat,$reqlong));
                    if($km < (int)$approw['bank_km']){

						$output_array["GTS"][$i]['blood_bank_id'] = (int)$row['blood_bank_id'];
						$output_array["GTS"][$i]['blood_bank_name'] = $row['blood_bank_name'];
						$output_array["GTS"][$i]['blood_bank_address'] = $row['blood_bank_address'];
						$output_array["GTS"][$i]['blood_bank_phone'] = $row['blood_bank_phone'];
						// $output_array["GTS"][$i]['blood_bank_latitude'] = $row['blood_bank_latitude'];
						// $output_array["GTS"][$i]['blood_bank_longitude'] = $row['blood_bank_longitude'];

					}

                $i++;
            }
		} else{
			http_response_code(500);
			$output_array['status'] = false;
			$output_array['message'] = "blood bank not found";
		}
	} else{
		http_response_code(400);
		$output_array['status'] = false;
		$output_array['message'] = "Bad request";
	}

	echo json_encode($output_array);
?>