<?php
    include("import.php");

    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);
          
            if($user_id){
             
                $blood_donor_age = $data->blood_donor_age;
                $donor_height = $data->donor_height;
                $donor_weight = $data->donor_weight;
                $donor_address = $data->donor_address;
                $donor_latitude = $data->donor_latitude;
                $donor_longitude = $data->donor_longitude;
                $any_diseases_status = $data->any_diseases_status;
                $any_allergies_status = $data->any_allergies_status;
                $take_any_medication = $data->take_any_medication;
                $bleeding_status = $data->bleeding_status;
                $cardiac_status = $data->cardiac_status;
                $hiv_status = $data->hiv_status;
                $last_donation_date = $data->last_donation_date;
               

                $sql = "SELECT * FROM user WHERE user_id='$user_id'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $sql = "UPDATE blood_donation SET blood_donor_age='$blood_donor_age',donor_height='$donor_height',donor_weight='$donor_weight',donor_address='$donor_address',donor_latitude='$donor_latitude',donor_longitude='$donor_longitude',bleeding_status='$bleeding_status',cardiac_status='$cardiac_status',hiv_status='$hiv_status',any_diseases_status='$any_diseases_status',any_allergies_status='$any_allergies_status',take_any_medication='$take_any_medication',last_time_donated_date='$last_donation_date' WHERE user_id='$user_id'";
                    if($conn->query($sql) === TRUE){
                        http_response_code(200);
                        $output_array['status'] = true;
                        $output_array['message'] = 'Ok';
                    } else{
                        http_response_code(500);
                        $output_array['status'] = false;
                        $output_array['query'] = $sql;
                    }
                } else{
                    http_response_code(404);
					$output_array['status'] = false;
					$output_array['message'] = "Data not found";
                }
            } else{
                http_response_code(400);
                $output_array['status'] = false;
                $output_array['message'] = "Bad request";
            }
        } else{
			http_response_code(401);
            $output_array['status'] = false;
            $output_array['message'] = "Invalid Authentication";
		}
	} else{
		http_response_code(401);
        $output_array['status'] = false;
        $output_array['message'] = "Authentication Missing";
	}

    echo json_encode($output_array);
?>