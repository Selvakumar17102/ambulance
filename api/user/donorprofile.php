<?php
    include("import.php");
    ini_set('display_errors','off');

    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

            $sql = "SELECT * FROM user WHERE user_id='$user_id'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();

                $donorSql = "SELECT * FROM `blood_donation` a LEFT OUTER JOIN bloodlist b ON a.blood_group = b.blood_id WHERE a.user_id = '$user_id'";
                $donorResult = $conn->query($donorSql);
                if($donorResult->num_rows > 0){
                    $donorrow = $donorResult->fetch_assoc();

                    $output_array['GTS']['user_id'] = (int)$donorrow['user_id'];
                    $output_array['GTS']['blood_donor_name'] = $donorrow['blood_donor_name'];
                    $output_array['GTS']['blood_donor_age'] = $donorrow['blood_donor_age'];
                    $output_array['GTS']['blood_donor_dob'] = $donorrow['blood_donor_dob'];
                    $output_array['GTS']['blood_donor_gender'] = $donorrow['blood_donor_gender'];
                    if($row['user_profile']){
                        $output_array['GTS']['profile_image'] = $IMAGE_BASE_URL.$row['user_profile'];
                    } else{
                        $output_array['GTS']['profile_image'] = "";
                    }
                    $output_array['GTS']['mobile_number'] = $row['user_phone_number'];
                    $output_array['GTS']['donor_alter_phone_no'] = $donorrow['donor_alter_phone_no'];
                    $output_array['GTS']['donor_address'] = $donorrow['donor_address'];
                    $output_array['GTS']['blood_group'] = $donorrow['blood_name'];
                    $output_array['GTS']['donor_height'] = $donorrow['donor_height'];
                    $output_array['GTS']['donor_weight'] = $donorrow['donor_weight'];
                    $output_array['GTS']['ever_donate_blood_before'] = $donorrow['ever_donate_blood_before'];
                    $output_array['GTS']['last_donation_date'] = $donorrow['last_time_donated_date'];
                    $output_array['GTS']['any_diseases_status'] = $donorrow['any_diseases_status'];
                    $output_array['GTS']['diseases_command'] = $donorrow['diseases_command'];
                    $output_array['GTS']['any_allergies_status'] = $donorrow['any_allergies_status'];
                    $output_array['GTS']['allergies_command'] = $donorrow['allergies_command'];
                    $output_array['GTS']['take_any_medication'] = $donorrow['take_any_medication'];
                    $output_array['GTS']['medication_command'] = $donorrow['medication_command'];
                    $output_array['GTS']['in_bitween_days'] = $donorrow['in_bitween_days'];
                    $output_array['GTS']['bleeding_status'] = $donorrow['bleeding_status'];
                    $output_array['GTS']['cardiac_status'] = $donorrow['cardiac_status'];
                    $output_array['GTS']['hiv_status'] = $donorrow['hiv_status'];
                    $output_array['status'] = true;
                }else{
                    http_response_code(404);
				    $output_array['status'] = false;
				    $output_array['message'] = "Donor Not register";
                }

            } else{
                http_response_code(404);
				$output_array['status'] = false;
				$output_array['message'] = "Data not found";
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