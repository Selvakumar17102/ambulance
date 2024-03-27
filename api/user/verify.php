<?php
	include("import.php");

	if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

			if(!empty($data->otp)){
				$otp = $data->otp;

				$sql = "SELECT * FROM user WHERE user_id='$user_id'";
				$result = $conn->query($sql);
				if($result->num_rows > 0){
					$row = $result->fetch_assoc();
					
					if(($row['user_otp'] == $otp)){
						$output_array['status'] = true;
					} else{
						http_response_code(403);
						$output_array['status'] = false;
						$output_array['message'] = "Invalid OTP";
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