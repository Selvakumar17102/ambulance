<?php
    include("import.php");
    include("../onesignaluser.php");
	include("../onesignaldelivery.php");
    ini_set('display_errors','off');
    date_default_timezone_set("Asia/Calcutta");

    $todayDate = date('Y-m-d');
    $todayTime = date('H:i:s');

    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

            if(!empty($data->order_id)){
                $order_id = $data->order_id;
                $order_status = $data->order_status;
                $cancel_reason = $data->cancel_reason;
                $drop_address = $data->drop_address;
                $drop_latitude = $data->drop_latitude;
                $drop_longitude = $data->drop_longitude;
                $payment_type = $data->payment_type;
                $otp = $data->otp;

                $check = 0;

                $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$user_id'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $driverTable = $result->fetch_assoc();

                    $sql = "SELECT * FROM orders WHERE order_id='$order_id'";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();

                        $orderString = $row['order_string'];
                        $branch_id = $row['login_id'];
                        $delivery_user_id = $row['user_id'];
                        $amountForClient = $row['amount_for_client'];
                        $total_amount = $row['total_amount'];
                        $service_type = $row['service_type'];
                        $pickup_address = $row['pickup_address'];
                        $pickup_latitude = $row['pickup_latitude'];
                        $pickup_longitude = $row['pickup_longitude'];

                        $AmountFromClient = $total_amount - $amountForClient;

                        if($order_status == 4){
                            if($service_type == 2){
                                if($row['pickup_otp'] == $otp){
                                    $check = 1;
                                }
                            } else{
                                $check = 1;
                            }
                        } else{
                            $check = 1;
                        }

                        if($check){
                            switch ($order_status) {
                                case 0:
                                    $sql1 = "UPDATE orders SET order_status='$order_status',cancel_time='$todayTime',cancel_reason='$cancel_reason',cancelled_by='Cancelled By Driver',cancelled_from='Driver App',delivery_partner_id='$user_id' WHERE order_id='$order_id'";
                                    break;
                                case 2:
                                    $sql1 = "UPDATE orders SET order_status='$order_status',accept_time='$todayTime',delivery_partner_id='$user_id' WHERE order_id='$order_id'";
                                    break;
                                case 3:
                                    $sql1 = "UPDATE orders SET order_status='$order_status',trip_start_time='$todayTime',delivery_partner_id='$user_id' WHERE order_id='$order_id'";
                                    break;
                                case 4:
                                    $sql1 = "UPDATE orders SET order_status='$order_status',pickup_time='$todayTime',delivery_partner_id='$user_id' WHERE order_id='$order_id'";
                                    break;
                                case 5:
                                    $sql1 = "UPDATE orders SET order_status='$order_status',drop_time='$todayTime',delivery_partner_id='$user_id' WHERE order_id='$order_id'";
                                    break;
                                case 6:
                                    $sql1 = "UPDATE orders SET order_status='$order_status',cash_collected_time='$todayTime',payment_type='$payment_type',delivery_partner_id='$user_id' WHERE order_id='$order_id'";
                                    break;
                                case 7:
                                    $sql1 = "UPDATE orders SET order_status='$order_status',trip_completed_time='$todayTime',delivery_partner_id='$user_id' WHERE order_id='$order_id'";
                                    break;
                            }
                            if($conn->query($sql1) === TRUE){
                                $sql = "SELECT user_name FROM user WHERE user_id='$delivery_user_id'";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
    
                                $user_name = $row['user_name'];

                                $title = 'Hi '.$user_name;

                                if($order_status == 0){
									$res = sendNotificationUser($delivery_user_id, $title, 'Booking cancelled by driver. Please book again!', '', $order_id, $order_status);
                                }

                                if($order_status == 2){
									$res = sendNotificationUser($delivery_user_id, $title, 'Ambulance request has been accepted by rider', '', $order_id, $order_status);
                                }

                                if($order_status == 3){
									$res = sendNotificationUser($delivery_user_id, $title, 'Ambulance on the way', '', $order_id, $order_status);
                                }

                                if($order_status == 4){
									$res = sendNotificationUser($delivery_user_id, $title, 'Ambulance reached pickup location', '', $order_id, $order_status);
                                }

                                if($order_status == 5){
                                    if($service_type == 1){
                                        if($drop_latitude && $drop_longitude){
                                            $km = round(getDistance($pickup_latitude,$pickup_longitude,$drop_latitude,$drop_longitude));
    
                                            $travel_distance = $km.' Km';

                                            if($km <= $driverTable['local_min_distance']){
                                                $totalCharge = $driverTable['local_charge'];
                                            } else{
                                                if($km <= $driverTable['long_min_distance']){
                                                    $totalCharge = round($driverTable['local_charge'] + ($driverTable['local_extra_charge_per_km'] * ($km - $driverTable['local_min_distance'])));
                                                } else{
                                                    if($km > $driverTable['long_min_distance']){
                                                        if($km <= $driverTable['long_max_distance']){
                                                            $totalCharge = $driverTable['long_charge'];
                                                        } else{
                                                            $totalCharge = round($driverTable['long_charge'] + ($driverTable['long_extra_charge_per_km'] * ($km - $driverTable['long_max_distance'])));
                                                        }
                                                    }
                                                }
                                            }

                                            $sql = "SELECT percentage_to_client,amount_to_client FROM app_control WHERE app_control_id='1'";
                                            $result = $conn->query($sql);
                                            $controlTable = $result->fetch_assoc();

                                            $percentage_to_client = $controlTable['percentage_to_client'];
                                            $amount_to_client = $controlTable['amount_to_client'];

                                            // if($amount_to_client){
                                            //     $amount_for_client = $amount_to_client;
                                            // } else{
                                                $amount_for_client = ($totalCharge * $percentage_to_client) / 100;
                                            // }

                                            $sql1 = "UPDATE orders SET drop_address='$drop_address',drop_latitude='$drop_latitude',drop_longitude='$drop_longitude',travel_distance='$travel_distance',total_amount='$totalCharge',amount_for_client='$amount_for_client' WHERE order_id='$order_id'";
                                            $conn->query($sql1);
                                        }
                                    }
                                    $res = sendNotificationUser($delivery_user_id, $title, 'Ambulance dropped at destination successfully', '', $order_id, $order_status);
                                }

                                if($order_status == 7){
                                    if($payment_type == "Cash On Hand"){
                                        $sql2 = "UPDATE delivery_partner SET total_cod_amount=total_cod_amount+$total_amount,amount_to_client=amount_to_client+$amountForClient WHERE delivery_partner_id='$user_id'";
                                        $conn->query($sql2);
                                    } else if($payment_type == "Razorpay"){
                                        $sql2 = "UPDATE delivery_partner SET total_razorpay_amount=total_razorpay_amount+$total_amount,amount_from_client=amount_from_client+$AmountFromClient WHERE delivery_partner_id='$user_id'";
                                        $conn->query($sql2);
                                    } else{
                                        $sql2 = "UPDATE delivery_partner SET total_qrcode_amount=total_qrcode_amount+$total_amount,amount_from_client=amount_from_client+$AmountFromClient WHERE delivery_partner_id='$user_id'";
                                        $conn->query($sql2);
                                    }
                                }

                                http_response_code(200);
                                $output_array['status'] = true;
                                $output_array['message'] = 'Ok';
                            } else{
                                http_response_code(500);
                                $output_array['status'] = false;
                                $output_array['message'] = 'Internal Server Error';
                            }
                        } else{
                            http_response_code(403);
                            $output_array['status'] = false;
                            $output_array['message'] = 'Invalid OTP';
                        }
                    } else{
                        http_response_code(404);
                        $output_array['status'] = false;
                        $output_array['message'] = 'Order not found';
                    }
                } else{
                    http_response_code(404);
                    $output_array['status'] = false;
                    $output_array['message'] = 'Delivery partner not found';
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