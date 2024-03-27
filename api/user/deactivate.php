<?php
    include("import.php");

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
                $status=0;
				$sql = "UPDATE user SET user_status='$status' WHERE user_id='$user_id'";
                if($conn->query($sql) === TRUE){
                    http_response_code(200);
                    $output_array['status'] = true;
                    $output_array['message'] = "Account Deactivated!";
                }else{
                    http_response_code(500);
                    $output_array['status'] = false;
                    $output_array['message'] = "Internal Server Error";
                }
                
            }else{
                http_response_code(404);
				$output_array['status'] = false;
				$output_array['message'] = "User not found";
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