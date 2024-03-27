<?php
	include("import.php");
    include("../onesignaluser.php");
    include("../onesignaldelivery.php");
	date_default_timezone_set("Asia/Calcutta");

	if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

			if(!empty($data->service_type) && !empty($data->pickup_address) && !empty($data->pickup_latitude) && !empty($data->pickup_longitude) && !empty($data->ambulance_id) && !empty($data->login_id)){
                $service_type = $data->service_type;
                $pickup_address = mysqli_real_escape_string($conn, $data->pickup_address);
                $pickup_latitude = $data->pickup_latitude;
                $pickup_longitude = $data->pickup_longitude;
                $drop_address = mysqli_real_escape_string($conn, $data->drop_address);
                $drop_latitude = $data->drop_latitude;
                $drop_longitude = $data->drop_longitude;
                $ambulance_id = $data->ambulance_id;
                $payment_type = $data->payment_type;
                $total_amount = $data->total_amount;
                $branch_id = $data->login_id;
                $order_status = 1;

                $pickup_otp = 0;
                if($service_type == 2){
                    $pickup_otp = mt_rand(1000,9999);
                }

                $booking_date = date('Y-m-d');
                $booking_time = date('H:i:s');

                $sql = "SELECT percentage_to_client,amount_to_client FROM app_control WHERE app_control_id='1'";
                $result = $conn->query($sql);
                $controlTable = $result->fetch_assoc();

                $percentage_to_client = $controlTable['percentage_to_client'];
                $amount_to_client = $controlTable['amount_to_client'];

                // if($amount_to_client){
                //     $amount_for_client = $amount_to_client;
                // } else{
                    $amount_for_client = ($total_amount * $percentage_to_client) / 100;
                // }

                $sql = "SELECT * FROM user WHERE user_id='$user_id'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();

                    $user_name = $row['user_name'];

                    $title = 'Hi '.$user_name;

                    $sql1 = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$ambulance_id'";
                    $result1 = $conn->query($sql1);
                    $driverTable1 = $result1->fetch_assoc();

                    $delivery_partner_name = $driverTable1['delivery_partner_name'];

                    $driverTitle = "Hi ".$delivery_partner_name;

                    $travel_distance = '0 Km';
                    if($service_type == 2){
                        $km = round(getDistance($pickup_latitude,$pickup_longitude,$drop_latitude,$drop_longitude));

                        $travel_distance = $km.' Km';
                    }

                    $sql = "SELECT * FROM orders ORDER BY order_id DESC LIMIT 1";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $order_id = $row['order_id'];
                    } else{
                        $order_id = 0;
                    }

                    $order_string = 'IA'.date('dm').$order_id;

                    $sql2 = "SELECT * FROM orders WHERE delivery_partner_id='$ambulance_id'";
                    $result2 = $conn->query($sql2);
                    if($result2->num_rows){
                        $driverOrderCount = ($result2->num_rows) + 1;
                    } else{
                        $driverOrderCount = 1;
                    }

                    $tripString = 'Trip - '.$driverOrderCount;

                    $sql = "INSERT INTO orders (order_string,trip_string,user_id,login_id,booking_date,booking_time,order_status,total_amount,service_type,pickup_address,pickup_latitude,pickup_longitude,drop_address,drop_latitude,drop_longitude,delivery_partner_id,travel_distance,amount_for_client,pickup_otp,payment_type) VALUES ('$order_string','$tripString','$user_id','$branch_id','$booking_date','$booking_time','$order_status','$total_amount','$service_type','$pickup_address','$pickup_latitude','$pickup_longitude','$drop_address','$drop_latitude','$drop_longitude','$ambulance_id','$travel_distance','$amount_for_client','$pickup_otp','$payment_type')";
                    if($conn->query($sql) === TRUE){
                        $order_id = $conn->insert_id;

                        $res = sendNotificationDelivery($ambulance_id, $driverTitle, "New Booking!", '', $order_id, '1', '');
                        $res = sendNotificationUser($user_id, $title, 'Your ambulance request has been sent successfully!', '', $order_id, '1');

                        $output_array['status'] = true;
                        $output_array['order_id'] = (int)$order_id;
                        $output_array['order_string'] = $order_string;
                    } else {
                        http_response_code(500);
                        $output_array['status'] = false;
                        $output_array['query'] = $sql;
                    }
                } else{
                    http_response_code(404);
                    $output_array['status'] = false;
                    $output_array['message'] = "User not found";
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