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

            $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$user_id'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();

                $branch_id = $row['delivery_partner_branch_id'];
                $vehicle_type_id = $row['vehicle_type'];

                $sql = "SELECT category_name FROM category WHERE category_id='$vehicle_type_id'";
                $result = $conn->query($sql);
                $catTable = $result->fetch_assoc();

                $output_array['GTS']['delivery_partner_id'] = $row['delivery_partner_id'];
                $output_array['GTS']['name'] = $row['delivery_partner_name'];
                if($row['delivery_partner_image']){
                    $output_array['GTS']['image'] = $IMAGE_BASE_URL.$row['delivery_partner_image'];
                } else{
                    $output_array['GTS']['image'] = $row['delivery_partner_image'];
                }
                $output_array['GTS']['phone'] = $row['delivery_partner_phone'];
                $output_array['GTS']['latitude'] = $row['delivery_partner_latitude'];
                $output_array['GTS']['longitude'] = $row['delivery_partner_longitude'];
                $output_array['GTS']['address'] = $row['delivery_partner_address'];
                $output_array['GTS']['alternate_mobile'] = $row['delivery_partner_alternate_mobile'];
                $output_array['GTS']['blood_group'] = $row['delivery_partner_blood_group'];
                $output_array['GTS']['date_of_birth'] = $row['delivery_partner_date_of_birth'];
                $output_array['GTS']['email'] = $row['delivery_partner_email'];
                $output_array['GTS']['gender'] = $row['delivery_partner_gender'];
                $output_array['GTS']['vehicle_name'] = $row['delivery_partner_vehicle_name'];
                $output_array['GTS']['vehicle_number'] = $row['delivery_partner_vehicle_number'];
                $output_array['GTS']['license_number'] = $row['license_number'];
                $output_array['GTS']['aadhaar_number'] = $row['aadhaar_number'];
                $output_array['GTS']['hospital_name'] = $row['hospital_name'];
                $output_array['GTS']['local_charge'] = (int)$row['local_charge'];
                $output_array['GTS']['local_min_distance'] = (int)$row['local_min_distance'];
                $output_array['GTS']['local_extra_charge_per_km'] = (int)$row['local_extra_charge_per_km'];
                $output_array['GTS']['long_min_distance'] = (int)$row['long_min_distance'];
                $output_array['GTS']['long_charge'] = (int)$row['long_charge'];
                $output_array['GTS']['long_max_distance'] = (int)$row['long_max_distance'];
                $output_array['GTS']['long_extra_charge_per_km'] = (int)$row['long_extra_charge_per_km'];
                $output_array['GTS']['is_emergency'] = (int)$row['emergency'];
                $output_array['GTS']['vehicle_type_id'] = (int)$row['vehicle_type'];
                $output_array['GTS']['vehicle_type_name'] = $catTable['category_name'];
                $output_array['GTS']['online_status'] = (int)$row['delivery_partner_online_status'];
                $output_array['GTS']['delivery_partner_status'] = (int)$row['delivery_partner_status'];

                $sql = "SELECT * FROM driver_image_file WHERE driver_id='$user_id'";
                $result = $conn->query($sql);
                $i = $j = $k = $l = 0;
                $licenseArray = $rcBookArray = $vehicleArray = $aadhaarArray = [];
                while($imageTable = $result->fetch_assoc()){

                    if($imageTable['type'] == 1){
                        if($imageTable['image']){
                            $licenseArray[$i]['image'] = $IMAGE_BASE_URL.$imageTable['image'];
                        } else{
                            $licenseArray[$i]['image'] = "";
                        }

                        $i++;
                    }

                    if($imageTable['type'] == 2){
                        if($imageTable['image']){
                            $rcBookArray[$j]['image'] = $IMAGE_BASE_URL.$imageTable['image'];
                        } else{
                            $rcBookArray[$j]['image'] = "";
                        }
                        $j++;
                    }

                    if($imageTable['type'] == 3){
                        if($imageTable['image']){
                            $vehicleArray[$k]['image'] = $IMAGE_BASE_URL.$imageTable['image'];
                        } else{
                            $vehicleArray[$k]['image'] = "";
                        }
                        $k++;
                    }

                    if($imageTable['type'] == 4){
                        if($imageTable['image']){
                            $aadhaarArray[$l]['image'] = $IMAGE_BASE_URL.$imageTable['image'];
                        } else{
                            $aadhaarArray[$l]['image'] = "";
                        }
                        $l++;
                    }

                }

                $output_array['GTS']['document']['license'] = $licenseArray;
                $output_array['GTS']['document']['rc_book'] = $rcBookArray;
                $output_array['GTS']['document']['vehicle'] = $vehicleArray;
                $output_array['GTS']['document']['aadhaar'] = $aadhaarArray;

                $sql = "SELECT * FROM branch WHERE login_id='$branch_id'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                $output_array['GTS']['branch']['branch_id'] = (int)$row['login_id'];
                $output_array['GTS']['branch']['branch_name'] = $row['branch_name'];
                if($row['branch_image']){
                    $output_array['GTS']['branch']['branch_image'] = $IMAGE_BASE_URL.$row['branch_image'];
                } else{
                    $output_array['GTS']['branch']['branch_image'] = "";
                }
                $output_array['GTS']['branch']['branch_intime'] = date('H:i', strtotime($row['branch_intime']));
                $output_array['GTS']['branch']['branch_outtime'] = date('H:i', strtotime($row['branch_outtime']));
                $output_array['GTS']['branch']['branch_address'] = $row['branch_address'];
                $output_array['GTS']['branch']['mobile_number'] = $row['branch_phone'];
                $output_array['GTS']['branch']['whatsapp_number'] = $row['branch_whatsapp'];

                http_response_code(200);
                $output_array['status'] = true;
                $output_array['message'] = 'Success';
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