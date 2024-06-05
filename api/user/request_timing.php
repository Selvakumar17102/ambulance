<?php
	include("import.php");
    include("../onesignaluser.php");
    include("../actiononesignaluser.php");
    include("../onesignaldelivery.php");
	date_default_timezone_set("Asia/Calcutta");

	if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

			$sql = "SELECT * FROM blood_request WHERE user_id ='$user_id' ORDER BY blood_request_id DESC LIMIT 1";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();

            $request_id = $row['blood_request_id'];

            $blood_group = $row['blood_group'];
            $request_time = $row['request_time'];

            $latitude = $row['latitude'];
            $longitude = $row['longitude'];

			switch ($blood_group) {
				case '1':
					$bloodname = "A+";
					break;
				case '2':
					$bloodname = "O+";
					break;
				case '3':
					$bloodname = "B+";
					break;
				case '4':
					$bloodname = "AB+";
					break;
				case '5':
					$bloodname = "AB-";
					break;
				case '6':
					$bloodname = "O-";
					break;
				case '7':
					$bloodname = "A-";
					break;
				case '8':
					$bloodname = "B-";
					break;
				case '9':
					$bloodname = "A1+";
					break;
				case '10':
					$bloodname = "A1-";
					break;
				case '11':
					$bloodname = "A2+";
					break;
				case '12':
					$bloodname = "A2-";
					break;
				case '13':
					$bloodname = "A1B+";
					break;
				case '14':
					$bloodname = "A1B-";
					break;
				case '15':
					$bloodname = "A2B+";
					break;
				case '16':
					$bloodname = "A2B-";
					break;
				case '17':
					$bloodname = "Bombay Blood Group";
					break;
				case '18':
					$bloodname = "INRA";
					break;
				default:
					$bloodname = "Don`t Know";
					break;
			}

            // $currentTime = date('H:i:s');
            // $after_10_minutes = date('H:i:s', strtotime($request_time. '+ 10 minutes'));
            // $after_50_minutes = date('H:i:s', strtotime($request_time. '+ 50 minutes'));


			$blood_donation_sql = "SELECT * FROM blood_donation WHERE blood_group = '$blood_group'";
            $blood_donation_result = $conn->query($blood_donation_sql);
            if($blood_donation_result->num_rows > 0){
                while($blood_donation_row = $blood_donation_result->fetch_assoc()){
					$donor_id = $blood_donation_row['user_id'];

					if($user_id != $donor_id){

                    	$blood_donation_id = $blood_donation_row['blood_donation_id'];

                    	$statusCheckSql = "SELECT * FROM rq_accept_reject WHERE donor_id='$donor_id' AND request_id='$request_id'";
                    	$statusResult = $conn->query($statusCheckSql);
                    	if($statusResult->num_rows == NULL){

                        	$donor_latitude = $blood_donation_row['donor_latitude'];
                        	$donor_longitude = $blood_donation_row['donor_longitude'];
    
                        	$km = round(getDistance($latitude,$longitude,$donor_latitude,$donor_longitude));
                        
                        	$currentTime = date('H:i:s');
                        	$after_5_minutes = date('H:i:s', strtotime($request_time. '+ 5 minutes'));
                        	$after_10_minutes = date('H:i:s', strtotime($request_time. '+ 5 minutes'));
    
                        	if($after_5_minutes <= $currentTime && $km <= 20){
							
                    			$title = 'Hi '.$blood_donation_row['blood_donor_name'];
								$res = sendNotificationUser($donor_id, $title, "Urgent Need .'$bloodname'. Blood !", '', $request_id, '1');
								$res = actionsendNotificationUser($donor_id, $title, "Urgent Need .'$bloodname'. Blood !", '', $request_id, '1');

                        	}elseif($after_10_minutes <= $currentTime && $km <= 50){

                    			$title = 'Hi '.$blood_donation_row['blood_donor_name'];
								$res = sendNotificationUser($donor_id, $title, "Urgent Need .'$bloodname'. Blood !", '', $request_id, '1');
								$res = actionsendNotificationUser($donor_id, $title, "Urgent Need .'$bloodname'. Blood !", '', $request_id, '1');
                        	}
                    	}
					}

				}
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