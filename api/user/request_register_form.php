<?php
	include("import.php");
    include("../onesignaluser.php");
    include("../onesignaldelivery.php");
	date_default_timezone_set("Asia/Calcutta");

	if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

			    if(!empty($data->patient_name) && !empty($data->blood_group) && !empty($data->unit)){
					$patient_name = $data->patient_name;
					$age = $data->age;
                    $phone_no = $data->phone_no;
                    $alter_phone_no = $data->alter_phone_no;
                    $blood_group = $data->blood_group;
					$blood_type = $data->blood_type;
                    $request_date = $data->request_date;
                    $unit = $data->unit;
                    $address = $data->address;
                    $emergency_status = $data->emergency_status;
					$latitude = $data->latitude;
					$longitude = $data->longitude;
                    // $city_id = $data->city_id;
                    // $additional_notes = $data->additional_notes;
                    // $check_terms = $data->check_terms;
                    $dummy_otp = rand(0001,9999);
					$request_reason_id = $data->request_reason_id;
					// $request_reason = $data->request_reason;
					$required_date = $data->required_date;
					$currentTime = date('H:i:s');

                    $sql = "INSERT INTO blood_request (user_id,patient_name,age,phone_no,alter_phone_no,blood_group,blood_type,request_date,unit,hospital_location,latitude,longitude,emergency_status,dummy_otp,required_date,request_reason,request_time)VALUES ('$user_id','$patient_name','$age','$phone_no','$alter_phone_no','$blood_group','$blood_type','$request_date','$unit','$address','$latitude','$longitude','$emergency_status','$dummy_otp','$required_date','$request_reason_id','$currentTime')";
                    if($conn->query($sql) === TRUE){
						$request_id = $conn->insert_id;

						$blood_donation_sql = "SELECT * FROM blood_donation WHERE blood_group = '$blood_group'";
                        $blood_donation_result = $conn->query($blood_donation_sql);
                        if($blood_donation_result->num_rows > 0){
							while($blood_donation_row = $blood_donation_result->fetch_assoc()){
								$donor_id = $blood_donation_row['user_id'];
                    			$title = 'Hi '.$blood_donation_row['blood_donor_name'];
								$res = sendNotificationUser($donor_id, $title, "Urgent Need .'$blood_group'. Blood !", '', $request_id, '1');
							}
						}
						
						// if($request_reason_id == 1){
						// 	$request_reason_sql = "INSERT INTO request_reason_list (request_id,reason) VALUES ('$request_id','$request_reason')";
						// }

                        http_response_code(200);
                        $output_array['status'] = true;
                        $output_array['message'] = "Register Successfully!";
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