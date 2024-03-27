<?php
	$output = array();
	include("import.php");
	include("../onesignaluser.php");
	include("../onesignaldelivery.php");
	date_default_timezone_set("Asia/Calcutta");

	$date = date('Y-m-d');
	$time = date('H:i:s');

	$rawdata = file_get_contents('php://input');
	$data = json_decode(file_get_contents('php://input'));
	$header = json_encode($header);

	if($data->event === 'payment.captured'){
		$order_string = $data->payload->payment->entity->notes->order_id;
		$razorpay_order_id = $data->payload->payment->entity->order_id;
		$razorpay_payment_id = $data->payload->payment->entity->id;

		$sql = "SELECT total_amount,order_status,user_id,order_id,login_id,delivery_partner_id,service_type,payment_type FROM orders WHERE order_string='$order_string'";
		$result = $conn->query($sql);
		if($result->num_rows){
			$row = $result->fetch_assoc();
	
			$user_id = $row['user_id'];
			$service_type = $row['service_type'];
			$order_id = $row['order_id'];
			$login_id = $row['login_id'];
			$driver_id = $row['delivery_partner_id'];
			$total_amount = $row['total_amount'];

			if($row['order_status'] == 5){
				$sql = "UPDATE orders SET razor_pay_id='$razorpay_payment_id',payment_message='Callback payment success',razorpay_order_id='$razorpay_order_id',payment_type='Razorpay' WHERE order_string='$order_string'";
				$conn->query($sql);
	
				$sql = "SELECT payment_type FROM orders WHERE order_string='$order_string'";
				$result = $conn->query($sql);
				$orderTable = $result->fetch_assoc();

				$payment_type = $orderTable['payment_type'];

				if($payment_type == "Razorpay"){
					$sql = "SELECT user_name FROM user WHERE user_id='$user_id'";
					$result = $conn->query($sql);
					$row = $result->fetch_assoc();
		
					$user_name = $row['user_name'];
		
					if($service_type == 2){
						$title = 'Hi '.$user_name;
						$res = sendNotificationUser($user_id,$title,'Payment Success!','',$order_id, '6');
					}
		
					$sql2 = "SELECT delivery_partner_name FROM delivery_partner WHERE delivery_partner_id='$driver_id'";
					$result2 = $conn->query($sql2);
					$row2 = $result2->fetch_assoc();

					$delivery_partner_name = $row2['delivery_partner_name'];
					
					$driverTitle = "Hi ".$delivery_partner_name;

					$res1 = sendNotificationDelivery($driver_id,$driverTitle,"Payment received!",'',$order_id, '6', '');
				}
			}
		}

		$sql = "INSERT INTO log_razorpay_webhook (date,time,data,header) VALUES ('$date','$time','$rawdata','$header')";
		if($conn->query($sql) === TRUE){
			$output['status'] = true;
		} else{
			http_response_code(500);
			$output['query'] = $sql;
		}
	} else{
		http_response_code(400);
		$output['status'] = false;
	}

	echo json_encode($output);
?>