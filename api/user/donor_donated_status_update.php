<?php
    include("import.php");

    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

            if(!empty($data->request_id) && !empty($data->dummyotp)){
                
                $request_id=$data->request_id;
                $dummyotp=$data->dummyotp;
            
                $sql = "SELECT * FROM user WHERE user_id='$user_id'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $reqSql = "SELECT * FROM blood_request WHERE blood_request_id = '$request_id' AND dummy_otp='$dummyotp'";
                    if($conn->query($reqSql) == TRUE){

                        $updateSql = "UPDATE rq_accept_reject SET danated_status='1' WHERE donor_id='$user_id' AND request_id='$request_id'";
                        if($conn->query($updateSql)===TRUE){
                            http_response_code(200);
                            $output_array['status'] = true;
                            $output_array['message'] = "Thanks";
                        }

                    }else{
                        http_response_code(404);
                        $output_array['status'] = false;
                        $output_array['message'] = "OTP mismatch";
                    }
                } else{
                    http_response_code(404);
                    $output_array['status'] = false;
                    $output_array['message'] = "user not found";
                }
            }else{
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