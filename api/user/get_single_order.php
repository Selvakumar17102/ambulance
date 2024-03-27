<?php
    include("import.php");
    date_default_timezone_set('Asia/Kolkata');
    // date_default_timezone_set("Asia/Calcutta");
    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

            if(!empty($data->order_id)){
                $order_id = $data->order_id;

                $sql = "SELECT * FROM user WHERE user_id='$user_id'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $sql = "SELECT * FROM orders WHERE user_id='$user_id' AND order_id='$order_id'";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $driver_id = $row['delivery_partner_id'];

                        $service_type=(int)$row['service_type'];

                        $sql5 = "SELECT * FROM service_type WHERE service_type_id = '$service_type'";
                        $result5 = $conn->query($sql5);
                        $row5 = $result5->fetch_assoc();

                        $sql1 = "SELECT * FROM delivery_partner WHERE delivery_partner_id = '$driver_id'";
                        $result1 = $conn->query($sql1);
                        $driverTable = $result1->fetch_assoc();

                        $km = 0;

                        if($row['order_status'] < 4){
                            $km = round(getDistance($driverTable['delivery_partner_latitude'],$driverTable['delivery_partner_longitude'],$row['drop_latitude'],$row['drop_longitude']));
                        }

                        switch ($row['order_status']) {
                            case 0:
                                $statusString = 'Cancelled';
                                break;
                            case 1:
                                $statusString = 'Booked';
                                break;
                            case 2:
                                $statusString = 'Aceepted';
                                break;
                            case 3:
                                $statusString = 'On The Way';
                                break;
                            case 4:
                                $statusString = 'Picked Up';
                                break;
                            case 5:
                                $statusString = 'Drop';
                                break;
                            case 6:
                                $statusString = 'Cash Collected';
                                break;
                            case 7:
                                $statusString = 'Completed';
                                break;
                            default:
                                $statusString = 'Pending';
                                break;
                        }

                        $output_array['GTS']['order_id'] = (int)$row['order_id'];
                        $output_array['GTS']['service_type'] = (int)$row['service_type'];
                        $output_array['GTS']['service_type_name'] = $row5['service_type_name'];
                        $output_array['GTS']['order_string'] = $row['order_string'];
                        $output_array['GTS']['total_amount'] = (int)$row['total_amount'];
                        $output_array['GTS']['order_status'] = (int)$row['order_status'];
                        $output_array['GTS']['status_string'] = $statusString;
                        $output_array['GTS']['payment_type'] = $row['payment_type'];
                        $output_array['GTS']['driver_name'] = $driverTable['delivery_partner_name'];
                        if($driverTable['delivery_partner_image']){
                            $output_array['GTS']['driver_image'] = $IMAGE_BASE_URL.$driverTable['delivery_partner_image'];
                        } else{
                            $output_array['GTS']['driver_image'] = "";
                        }
                        $output_array['GTS']['driver_mobile'] = $driverTable['delivery_partner_phone'];
                        $output_array['GTS']['driver_latitude'] = $driverTable['delivery_partner_latitude'];
                        $output_array['GTS']['driver_longitude'] = $driverTable['delivery_partner_longitude'];
                        $output_array['GTS']['driver_distance'] = $km.' Km';
                        $output_array['GTS']['ambulance_name'] = $driverTable['delivery_partner_vehicle_name'];
                        $output_array['GTS']['hospital_name'] = $driverTable['hospital_name'];
                        $output_array['GTS']['distance'] = $row['travel_distance'];
                        $output_array['GTS']['time'] = $row['travel_time'];
                        $output_array['GTS']['pickup_address'] = $row['pickup_address'];
                        $output_array['GTS']['pickup_latitude'] = $row['pickup_latitude'];
                        $output_array['GTS']['pickup_longitude'] = $row['pickup_longitude'];
                        $output_array['GTS']['drop_address'] = $row['drop_address'];
                        $output_array['GTS']['drop_latitude'] = $row['drop_latitude'];
                        $output_array['GTS']['drop_longitude'] = $row['drop_longitude'];
                        $output_array['GTS']['pickup_otp'] = (int)$row['pickup_otp'];
                        $output_array['GTS']['booking_date'] = date('d M, D Y, ', strtotime($row['booking_date'])).date('h:i A', strtotime($row['booking_time']));
                        $output_array['GTS']['booking_date'] = date('d-m-Y', strtotime($row['booking_date']));
                        $output_array['GTS']['booking_time'] = date('h:i A', strtotime($row['booking_time']));
                        $output_array['status'] = true;
                    } else {
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