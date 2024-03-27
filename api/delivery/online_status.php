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

            $status = $data->status;

            $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$user_id'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $sql = "UPDATE delivery_partner SET delivery_partner_online_status='$status' WHERE delivery_partner_id='$user_id'";
                if($conn->query($sql) === TRUE){
                    $output_array['status'] = true;
                    $output_array['message'] = 'Success';
                }
            } else{
                http_response_code(404);
                $output_array['status'] = false;
                $output_array['message'] = 'Delivery partner not found';
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