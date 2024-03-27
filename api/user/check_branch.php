<?php
	include("import.php");
	
	if(!empty($data->latitude) && !empty($data->longitude)){
		$latitude = $data->latitude;
		$longitude = $data->longitude;

		$sql = "SELECT 
                    login_id, 
                    branch_name, 
                    branch_image, 
                    branch_phone, 
                    branch_whatsapp, 
                    branch_address, 
                    branch_intime, 
                    branch_outtime, 
                    branch_latitude, 
                    branch_longitude, 
                    branch_status, 
                    maximum_coverage, 
                    razorpay_merchant_id, 
                    razorpay_merchant_key, 
                    ( 3959 * acos( ( cos( radians($latitude) ) * cos( radians( branch_latitude ) ) * cos( radians( branch_longitude ) - radians($longitude) ) ) + ( sin( radians($latitude) ) * sin( radians( branch_latitude ) ) ) ) ) * 1.609344 
                    AS 
                    distance 
                FROM 
                    branch 
                ORDER BY distance LIMIT 1";
		$result = $conn->query($sql);
		if($result->num_rows){
            $row = $result->fetch_assoc();

            if($row['branch_status']){
                $output_array["GTS"]['branch_id'] = (int)$row['login_id'];
                $output_array["GTS"]['branch_name'] = $row['branch_name'];
                $output_array["GTS"]['mobile_number'] = $row['branch_phone'];
                $output_array["GTS"]['whatsapp'] = '+91'.$row['branch_whatsapp'];
                $output_array["GTS"]['branch_intime'] = date('H:i', strtotime($row['branch_intime']));
                $output_array["GTS"]['branch_outtime'] = date('H:i', strtotime($row['branch_outtime']));                  
                $output_array["GTS"]['branch_address'] = $row['branch_address'];
                $output_array["GTS"]['branch_latitude'] = (float)$row['branch_latitude'];
                $output_array["GTS"]['branch_longitude'] = (float)$row['branch_longitude'];
                $output_array["GTS"]['razorpay_merchant_id'] = $row['razorpay_merchant_id'];
                $output_array["GTS"]['razorpay_merchant_key'] = $row['razorpay_merchant_key'];
                $output_array["GTS"]['branch_status'] = (int)$row['branch_status'];

                $output_array['status'] = true;
            } else{
                http_response_code(404);
                $output_array['status'] = false;
                $output_array['message'] = "Data not found";
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