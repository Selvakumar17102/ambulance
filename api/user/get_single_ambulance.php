<?php
    include("import.php");

    if(!empty($header['authorization'])){
        $token = $header['authorization'];
    
		$responceData = checkAndGenerateToken($conn,$token);
        
		if($responceData['status']){
            $user_id = $responceData['user_id'];
        }
    }

    if(!empty($data->ambulance_id) && !empty($data->login_id)){
        $login_id = $data->login_id;
        $driver_id = $data->ambulance_id;
        $pickup_latitude = $data->pickup_latitude;
        $pickup_longitude = $data->pickup_longitude;
        $drop_latitude = $data->drop_latitude;
        $drop_longitude = $data->drop_longitude;
        $service_type = $data->service_type;
        
        $sql4 = "SELECT * FROM login WHERE login_id='$login_id'";
        $result4 = $conn->query($sql4);
        if($result4->num_rows > 0){
            $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_branch_id='$login_id' AND delivery_partner_id='$driver_id' AND request_status=2 AND delivery_partner_online_status=1 AND delivery_partner_status=1";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $driverTable = $result->fetch_assoc();

                $km = round(getDistance($driverTable['delivery_partner_latitude'], $driverTable['delivery_partner_longitude'], $pickup_latitude, $pickup_longitude));

                $kmCharge = 0;
                if($drop_latitude && $drop_longitude){
                    $kmCharge = round(getDistance($pickup_latitude,$pickup_longitude,$drop_latitude,$drop_longitude));
                }

                if($kmCharge <= $driverTable['local_min_distance']){
                    $amount = $driverTable['local_charge'];
                } else{
                    if($kmCharge <= $driverTable['long_min_distance']){
                        $amount = round($driverTable['local_charge'] + ($driverTable['local_extra_charge_per_km'] * ($kmCharge - $driverTable['local_min_distance'])));
                    } else{
                        if($kmCharge > $driverTable['long_min_distance']){
                            if($kmCharge <= $driverTable['long_max_distance']){
                                $amount = $driverTable['long_charge'];
                            } else{
                                $amount = round($driverTable['long_charge'] + ($driverTable['long_extra_charge_per_km'] * ($kmCharge - $driverTable['long_max_distance'])));
                            }
                        }
                    }
                }

                $sql2 = "SELECT * FROM driver_image_file WHERE driver_id='$driver_id' AND type=3";
                $result2 = $conn->query($sql2);
                $imageTable = $result2->fetch_assoc();

                $output_array['GTS']['id'] = (int)$driverTable['delivery_partner_id'];
                $output_array['GTS']['driver_name'] = $driverTable['delivery_partner_name'];
                $output_array['GTS']['ambulance_name'] = $driverTable['delivery_partner_vehicle_name'];
                $output_array['GTS']['hospital_name'] = $driverTable['hospital_name'];
                if($imageTable['image']){
                    $output_array['GTS']['image'] = $IMAGE_BASE_URL.$imageTable['image'];
                } else{
                    $output_array['GTS']['image'] = "";
                }
                $output_array['GTS']['distance'] = $km.' Km';
                $output_array['GTS']['time'] = '';
                $output_array['GTS']['amount'] = (int)$amount;

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