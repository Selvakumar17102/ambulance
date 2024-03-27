<?php
	include("import.php");
	include("../onesignaldelivery.php");
	date_default_timezone_set("Asia/Calcutta");

    $date = date('Y-m-d');
	$time = date('H:i:s');

	if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

			if(!empty($data->order_id)){
				$order_id = $data->order_id;
				$cancel_reason = $data->cancel_reason;
		
				$sql = "SELECT * FROM user WHERE user_id='$user_id'";
				$result = $conn->query($sql);
				if($result->num_rows > 0){
					$sql = "SELECT * FROM orders WHERE user_id='$user_id' AND order_id='$order_id'";
					$result = $conn->query($sql);
					if($result->num_rows > 0){
						$row = $result->fetch_assoc();

						$driver_id = $row['delivery_partner_id'];

						$sql2 = "SELECT delivery_partner_name FROM delivery_partner WHERE delivery_partner_id='$driver_id'";
						$result2 = $conn->query($sql2);
						$row2 = $result2->fetch_assoc();

						$delivery_partner_name = $row2['delivery_partner_name'];
						
						$driverTitle = "Hi ".$delivery_partner_name;

						$sql = "UPDATE orders SET order_status='0',cancel_reason='$cancel_reason',cancelled_by='Cancelld By User',cancelled_from='User App' WHERE order_id='$order_id'";
						if($conn->query($sql) === TRUE){
							$res = sendNotificationDelivery($driver_id,$driverTitle,"Booking cancelled by user!",'',$order_id, '0', '');

							$output_array['status'] = true;
						}
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