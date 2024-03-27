<?php
    include("import.php");

    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

            if(!empty($data->login_id)){
                $login_id = $data->login_id;
                $pickup_latitude = $data->pickup_latitude;
                $pickup_longitude = $data->pickup_longitude;
                $drop_latitude = $data->drop_latitude;
                $drop_longitude = $data->drop_longitude;
                $service_type = $data->service_type;

                $sql = "SELECT * FROM user WHERE user_id='$user_id'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $near_delivery_partners = array();

                    $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_branch_id='$login_id' AND emergency = 1 AND request_status=2 AND delivery_partner_online_status=1 AND delivery_partner_status=1 AND (emergency=1 OR emergency=2)";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        $i = 0;
                        while($driverTable = $result->fetch_assoc()){
                            $driverId = $driverTable['delivery_partner_id'];

                            if($driverTable['delivery_partner_latitude'] && $driverTable['delivery_partner_longitude']){
                                $sql1 = "SELECT * FROM orders WHERE delivery_partner_id='$driverId' AND order_status >= 1 AND order_status < 7";
                                $result1 = $conn->query($sql1);
                                if($result1->num_rows == 0){
                                    $km = round(getDistance($driverTable['delivery_partner_latitude'],$driverTable['delivery_partner_longitude'],$pickup_latitude,$pickup_longitude));
                                    
                                    // if($km <= 20){
                                        $near_delivery_partners[$driverTable['delivery_partner_id']] = (int)$km;
                                        // }
                                }
                            }
                        }

                        asort($near_delivery_partners);

                        if(count($near_delivery_partners)){
                            foreach ($near_delivery_partners as $delivery_partner_id => $km) {
                                $sql1 = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
                                $result1 = $conn->query($sql1);
                                $driverTable1 = $result1->fetch_assoc();
    
                                $kmCharge = 0;
                                if($drop_latitude && $drop_longitude){
                                    $kmCharge = round(getDistance($pickup_latitude,$pickup_longitude,$drop_latitude,$drop_longitude));
                                }

                                if($kmCharge <= $driverTable1['local_min_distance']){
                                    $amount = $driverTable1['local_charge'];
                                } else{
                                    if($kmCharge <= $driverTable1['long_min_distance']){
                                        $amount = round($driverTable1['local_charge'] + ($driverTable1['local_extra_charge_per_km'] * ($kmCharge - $driverTable1['local_min_distance'])));
                                    } else{
                                        if($kmCharge > $driverTable1['long_min_distance']){
                                            if($kmCharge <= $driverTable1['long_max_distance']){
                                                $amount = $driverTable1['long_charge'];
                                            } else{
                                                $amount = round($driverTable1['long_charge'] + ($driverTable1['long_extra_charge_per_km'] * ($kmCharge - $driverTable1['long_max_distance'])));
                                            }
                                        }
                                    }
                                }
    
                                $sql2 = "SELECT * FROM driver_image_file WHERE driver_id='$delivery_partner_id' AND type=3";
                                $result2 = $conn->query($sql2);
                                $imageTable = $result2->fetch_assoc();
    
                                $output_array['GTS'][$i]['id'] = (int)$driverTable1['delivery_partner_id'];
                                $output_array['GTS'][$i]['driver_name'] = $driverTable1['delivery_partner_name'];
                                $output_array['GTS'][$i]['ambulance_name'] = $driverTable1['delivery_partner_vehicle_name'];
                                $output_array['GTS'][$i]['hospital_name'] = $driverTable1['hospital_name'];
                                if($imageTable['image']){
                                    $output_array['GTS'][$i]['image'] = $IMAGE_BASE_URL.$imageTable['image'];
                                } else{
                                    $output_array['GTS'][$i]['image'] = "";
                                }
                                $output_array['GTS'][$i]['distance'] = $km.' Km';
                                $output_array['GTS'][$i]['time'] = '';
                                $output_array['GTS'][$i]['amount'] = (int)$amount;
    
                                $i++;
                            }
    
                            if($i){
                                $output_array['status'] = true;
                            } else{
                                http_response_code(404);
                                $output_array['status'] = false;
                            }
    
                            http_response_code(200);
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
                    http_response_code(404);
                    $output_array['status'] = false;
                    $output_array['message'] = "Data not found";
                }
            } else{
                http_response_code(400);
                $output_array['status'] = false;
                $output_array['message'] = "Bad Request";
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