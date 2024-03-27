<?php
	include("import.php");

    if(!empty($data->mobile) && !empty($data->fcm) && !empty($data->password)){
        $phone = $data->mobile;
        $password = $data->password;
        $fcm = $data->fcm;

        $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_phone='$phone'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();

            if($row['request_status'] == 2){
                if($row['delivery_partner_status']){
                    if(chechPass($conn,$row['delivery_partner_password'],$row['delivery_partner_cipher'],$password)){
        
                        $delivery_partner_id = $row["delivery_partner_id"];
        
                        $responce = createToken($conn,$delivery_partner_id);
                        if($responce['current_token']){
                            $token = $responce['current_token'];
                            $refresh_token = $responce['refresh_token'];
        
                            $sql = "UPDATE delivery_partner SET delivery_partner_fcm='$fcm',refresh_token='$refresh_token' WHERE delivery_partner_id='$delivery_partner_id'";
                            if($conn->query($sql) === TRUE){
                                http_response_code(200);
                                $output_array['status'] = true;
                                $output_array['message'] = 'OK';
                                $output_array['token'] = $token;
                            } else{
                                http_response_code(500);
                                $output_array['status'] = false;
                                $output_array['query'] = $sql;
                            }
                        } else{
                            http_response_code(500);
                            $output_array['status'] = false;
                            $output_array['message'] = $responce;
                        }
                    } else{
                        http_response_code(403);
                        $output_array['status'] = false;
                        $output_array['message'] = 'Invalid Password';
                    }
                } else{
                    http_response_code(403);
                    $output_array['status'] = false;
                    $output_array['message'] = 'Login restricted';
                }
            } else{
                if($row['request_status'] == 1){
                    http_response_code(403);
                    $output_array['status'] = false;
                    $output_array['message'] = 'Verification process going on';
                } else{
                    http_response_code(403);
                    $output_array['status'] = false;
                    $output_array['message'] = 'Application Rejected';
                }
            }
        }else{
            http_response_code(404);
            $output_array['status'] = false;
            $output_array['message'] = "Delivery partner not found";
        }
	} else{
		http_response_code(400);
		$output_array['status'] = false;
		$output_array['message'] = "Bad request";
	}

	echo json_encode($output_array);
?>