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

			if(!empty($data->order_id)){
				$order_id = $data->order_id;
				$payment_type = $data->payment_type;
				$payment_status = $data->payment_status;
				$payment_message = mysqli_real_escape_string($conn, $data->payment_message);
				$razorPayId = $data->razorPayId;
				$razorpay_order_id = $data->razorpay_order_id;
				$booking_date = date('Y-m-d');
				$booking_time = date('H:i:s');

				$sql = "SELECT * FROM orders WHERE order_id='$order_id'";
				$result = $conn->query($sql);
				if($result->num_rows > 0){
					$row = $result->fetch_assoc();

					$order_string = $row['order_string'];
					$service_type = $row['service_type'];
					$driver_id = $row['delivery_partner_id'];
					$branch_id = $row['login_id'];
					$user_id = $row['user_id'];
					$total_amount = $row['total_amount'];

					$sql2 = "SELECT delivery_partner_name FROM delivery_partner WHERE delivery_partner_id='$driver_id'";
					$result2 = $conn->query($sql2);
					$row2 = $result2->fetch_assoc();

					$delivery_partner_name = $row2['delivery_partner_name'];
					
					$driverTitle = "Hi ".$delivery_partner_name;

					if($payment_status){
						if($row['order_status'] == 5){
							$sql = "UPDATE orders SET payment_type='$payment_type',payment_message='$payment_message',razor_pay_id='$razorPayId',razorpay_order_id='$razorpay_order_id' WHERE order_id='$order_id'";
							if($conn->query($sql) === TRUE){
								if($payment_type == "Razorpay"){

									$res = sendNotificationDelivery($driver_id,$driverTitle,"Payment received!",'',$order_id, '5', '');
	
									$sql = "SELECT user_name FROM user WHERE user_id='$user_id'";
									$result = $conn->query($sql);
									$row = $result->fetch_assoc();
		
									$user_name = $row['user_name'];
	
									if($service_type == 2){		
										$title = 'Hi '.$user_name;
										$res = sendNotificationUser($user_id,$title,'Payment Success!','',$order_id, '5');
									}
								}
								$output_array['status'] = true;
							}
						} else{
							http_response_code(403);
							$output_array['status'] = false;
						}
					} else{
						http_response_code(404);
						$output_array['status'] = false;
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
			$output_array['message'] = "Authentication Missing";
		}
	} else{
		http_response_code(401);
        $output_array['status'] = false;
        $output_array['message'] = "Authentication Missing";
	}

	echo json_encode($output_array);
?>