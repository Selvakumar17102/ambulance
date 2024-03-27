<?php
	include('include/connection.php');
	include('../api/fcm.php');
	include('../api/onesignaldelivery.php');
	include('../api/onesignaluser.php');
	include('../api/distance-calculator.php');

	$id = $_REQUEST['id'];

	$sql = "SELECT * FROM orders WHERE order_id='$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	$user_id = $row['user_id'];
	$login_id = $row['login_id'];
	$order_string = $row['order_string'];

	$otp = rand(0000, 9999);

	$sql = "SELECT * FROM user WHERE user_id='$user_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	$user_name = $row['user_name'];
	$user_fcm_token = $row['user_fcm_token'];

	$sql = "SELECT * FROM branch WHERE login_id='$login_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	$branch_latitude = $row['branch_latitude'];
	$branch_longitude = $row['branch_longitude'];

	$delivery_partner = array();

	$sql = "SELECT * FROM delivery_partner WHERE delivery_partner_branch_id='$login_id' AND delivery_partner_online_status=1 AND delivery_partner_status=1";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$delivery_partner_id = $row['delivery_partner_id'];
		$delivery_partner_latitude = $row['delivery_partner_latitude'];
		$delivery_partner_longitude = $row['delivery_partner_longitude'];

		$delivery_partner[$delivery_partner_id] = getDistance($branch_latitude,$branch_longitude,$delivery_partner_latitude,$delivery_partner_longitude);
	}

	asort($delivery_partner);

	$sql = "UPDATE orders SET order_status='2',pickup_otp='$otp' WHERE order_id='$id'";
	if($conn->query($sql) === TRUE){
		header('Location: newOrder1.php?msg=Trip accepted!');
	}
?>