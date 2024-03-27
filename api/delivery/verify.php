<?php
	include("import.php");

    if(!empty($data->otp) && !empty($data->user_id)){
        $user_id = $data->user_id;
        $otp = $data->otp;

        $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$user_id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            
            if(($row['delivery_partner_otp'] == $otp)){
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

	echo json_encode($output_array);
?>