<?php
    include("import.php");
    ini_set('display_errors','off');

    if(!empty($data->mobile)){
        $mobile = $data->mobile;

        // $randomid = mt_rand(1000,9999);

		// if($mobile == "+911234567890"){
			$randomid = 1234;
		// }

		$msg = "Your login OTP to Signup for Instant Ambulance Account is ".$randomid.".";
		$msg = urlencode($msg);

        $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_phone='$mobile'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();

            if($row['delivery_partner_status'] == 1){
                $sql1 = "UPDATE delivery_partner SET delivery_partner_otp='$randomid' WHERE delivery_partner_phone='$mobile'";
                if($conn->query($sql1) === TRUE){
                    $phone = ltrim($mobile, '+');
                    // $responce = SendOTP($phone,$msg,$randomid);
                    // if($responce->type == 'success'){
                        $output_array['user_id'] = (int)$row['delivery_partner_id'];
                        $output_array['status'] = true;
                        $output_array['message'] = 'Success';
                    // } else{
                    //     http_response_code(402);
                    //     $output_array['status'] = false;
                    //     $output_array['message'] = 'Unable to send OTP';
                    //     $output_array['responce'] = $responce;
                    // }
                } else{
                    http_response_code(500);
                    $output_array['status'] = false;
                    $output_array['query'] = $sql1;
                }
            } else{
                http_response_code(403);
                $output_array['status'] = false;
                $output_array['message'] = 'Delivery partner access needed';
            }
        } else{
            http_response_code(404);
            $output_array['status'] = false;
            $output_array['message'] = 'Delivery partner not found';
        }
    } else{
        http_response_code(400);
        $output_array['status'] = false;
        $output_array['message'] = 'Bad Request';
    }

    echo json_encode($output_array);
?>