<?php
	// Defaults
	include("../../dashboard/include/connection.php");
	// date_default_timezone_set("Asia/Calcutta");
	date_default_timezone_set('Asia/Kolkata');
	
	// Requirements
	include("../code.php");
	include("../distance-calculator.php");
	include("../fcm.php");
	include("../hash.php");
	include("../jwt.php");
	include("../otp_sender.php");
	include("../password.php");


	// header
	header('Access-Control-Allow-Origin: *');
    header('Access-Control-Expose-Headers: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With, authentication');
    header('Content-Type: application/json');

	// Receivables
	$data = json_decode(file_get_contents('php://input'));
	$header = apache_request_headers();
	$output_array = array();

	if($header['Authorization']){
		$header['authorization'] = $header['Authorization'];
	}

	// Options
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		$output_array['status'] = true;

		echo json_encode($output_array);
		exit();
	}

	$IMAGE_BASE_URL = "https://salvo.gtechlab.in/dashboard/";
	// $IMAGE_BASE_URL = "http://localhost/ambulance/dashboard/";
?>