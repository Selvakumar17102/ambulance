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
                
			    if(!empty($data->blood_donor_name) && !empty($data->blood_group)){
                    // $blood_donor_status = $data->blood_donor_status;
                    $blood_donor_name = $data->blood_donor_name;
                    $blood_donor_age = $data->blood_donor_age;
                    $blood_donor_dob = $data->blood_donor_dob;
                    $blood_donor_gender = $data->blood_donor_gender;
                    $donor_phone_no = $data->alter_phone_no;
                    $donor_city_id = $data->donor_city_id;
                    $donor_address = $data->donor_address;
                    $donor_latitude = $data->donor_latitude;
                    $donor_longitude = $data->donor_longitude;
                    $blood_group = $data->blood_group;
                    $donor_height = $data->donor_height;
                    $donor_weight = $data->donor_weight;
                    // $ever_donate_blood_before = $data->ever_donate_blood_before;
                    // $last_time_donated_date = $data->last_time_donated_date;
                    $any_diseases_status = $data->any_diseases_status;
                    $diseases_command = $data->diseases_command;
                    $any_allergies_status = $data->any_allergies_status;
                    $allergies_command = $data->allergies_command;
                    $any_medication_status = $data->any_medication_status;
                    $medication_command = $data->medication_command;
                    $bleeding_status = $data->bleeding_status;
                    $cardiac_status = $data->cardiac_status;
                    $hiv_status = $data->hiv_status;
                    $blood_donation_midperiod = $data->blood_donation_midperiod;
                    // $in_bitween_days = $data->in_bitween_days;
                    
                    $checkSql = "SELECT * FROM blood_donation WHERE user_id='$user_id'";
                    $checkResult = $conn->query($checkSql);
                    if($checkResult->num_rows == NULL){

                        $sql = "INSERT INTO blood_donation (user_id,blood_donor_name,blood_donor_age,blood_donor_dob,blood_donor_gender,donor_alter_phone_no,donor_city_id,donor_address,donor_latitude,donor_longitude,blood_group,donor_height,donor_weight,any_diseases_status,diseases_command,any_allergies_status,allergies_command,take_any_medication,medication_command,bleeding_status,cardiac_status,hiv_status,blood_donation_midperiod) VALUES ('$user_id','$blood_donor_name','$blood_donor_age','$blood_donor_dob','$blood_donor_gender','$donor_phone_no','$donor_city_id','$donor_address','$donor_latitude','$donor_longitude','$blood_group','$donor_height','$donor_weight','$any_diseases_status','$diseases_command','$any_allergies_status','$allergies_command','$any_medication_status','$medication_command','$bleeding_status','$cardiac_status','$hiv_status','$blood_donation_midperiod')";
                        if($conn->query($sql) === TRUE){
                            http_response_code(200);
                            $output_array['status'] = true;
                            $output_array['message'] = "Register Successfully!";
                        }

                    }else{
                        http_response_code(404);
                        $output_array['status'] = false;
                        $output_array['message'] = "User Already Exist";
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