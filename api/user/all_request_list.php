<?php
    include("import.php");

    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

            // $sql = "SELECT * FROM user WHERE user_id='$user_id'";
            // $result = $conn->query($sql);
            // if($result->num_rows > 0){
            //     $row = $result->fetch_assoc();


                    $reqSql ="SELECT * FROM blood_request a LEFT OUTER JOIN bloodlist b ON a.blood_group = b.blood_id WHERE a.user_id='$user_id'";
                    $reqResult = $conn->query($reqSql);
                    $i = 0;
                    if($reqResult->num_rows > 0){
                        while($reqRow = $reqResult->fetch_assoc()){

                                if($reqRow['emergency_status'] == 1){
                                    $eStatus = "Emergency";
                                }else{
                                    $eStatus = "Non-Emergency";
                                }
                                $output_array['GTS'][$i]['blood_request_id'] = $reqRow['blood_request_id'];
                                $output_array['GTS'][$i]['patient_name'] = $reqRow['patient_name'];
                                $output_array['GTS'][$i]['age'] = $reqRow['age'];
                                $output_array['GTS'][$i]['blood_type'] = $reqRow['blood_type'];
                                $output_array['GTS'][$i]['blood_group'] = $reqRow['blood_name'];
                                $output_array['GTS'][$i]['phone_number'] = $reqRow['phone_no'];
                                $output_array['GTS'][$i]['alter_phone_no'] = $reqRow['alter_phone_no'];
                                $output_array['GTS'][$i]['request_date'] = $reqRow['request_date'];
                                $output_array['GTS'][$i]['unit'] = $reqRow['unit'];
                                $output_array['GTS'][$i]['hospital_location'] = $reqRow['hospital_location'];
                                $output_array['GTS'][$i]['lat'] = $reqRow['latitude'];
                                $output_array['GTS'][$i]['long'] = $reqRow['longitude'];
                                $output_array['GTS'][$i]['emergency_status'] = $eStatus;
                                $output_array['GTS'][$i]['status'] = $reqRow['status'];

                            $i++;

                            $output_array['status'] = true;
                        }
                    }else{
                        http_response_code(404);
					    $output_array['status'] = false;
					    $output_array['message'] = "Request not found";
                    }
            // } else{
            //     http_response_code(404);
            //     $output_array['status'] = false;
            //     $output_array['message'] = "Data not found";
            // }
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