<?php
	include("import.php");

	if(!empty($data->mobile)){
		$phone = $data->mobile;
		$fcm = $data->fcm;
		$player_id = $data->player_id;
		$version = $data->version;
		$device = $data->device;
		$check = 0;

		$date = date('Y-m-d');
		// $randomid = mt_rand(1000,9999);
		$randomid = "1234";
		if($phone == "+911234567890"){
			$randomid = 1234;
		}

		$msg = "Your login OTP to Signup for Instant Ambulance Account is ".$randomid.".";
		$msg = urlencode($msg);

		$sql = "SELECT * FROM user WHERE user_phone_number='$phone'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			$row = $result->fetch_assoc();
			if($row['version'] != $version){
				$sql = "UPDATE user SET player_id='$player_id',user_fcm_token='$fcm',user_otp='$randomid',version='$version',device='$device',last_updated_date='$date' WHERE user_phone_number='$phone'";
			} else{
				$sql = "UPDATE user SET player_id='$player_id',user_fcm_token='$fcm',user_otp='$randomid',device='$device' WHERE user_phone_number='$phone'";
			}
		}else{
			$sql = "INSERT INTO user (user_phone_number,user_registration_date,user_fcm_token,user_otp,version,device,last_updated_date,player_id) VALUES ('$phone','$date','$fcm','$randomid','$version','$device','$date','$player_id')";
		}
		if($conn->query($sql) === TRUE){
			$sql = "SELECT * FROM user WHERE user_phone_number='$phone' AND user_status='1'";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				$row = $result->fetch_assoc();

				$user_id = $row["user_id"];

				$responce = createToken($conn,$user_id);
				if($responce['current_token']){
					$token = $responce['current_token'];
					$refresh_token = $responce['refresh_token'];

					$sql = "UPDATE user SET refresh_token='$refresh_token' WHERE user_id='$user_id'";
					if($conn->query($sql) === TRUE){

						$phone = ltrim($phone, '+');
						$responce = SendOTP($phone,$msg,$randomid);
						if($responce->type == 'success'){
							http_response_code(200);
							$output_array['status'] = true;
							$output_array['message'] = 'OK';
							$output_array['token'] = $token;
						} else{
							http_response_code(402);
							$output_array['status'] = false;
							$output_array['message'] = 'Unable to send OTP';
							$output_array['responce'] = $responce;
						}
					} else{
						http_response_code(500);
						$output_array['status'] = false;
						$output_array['query'] = $sql;
					}
				} else{
					http_response_code(500);
					$output_array['status'] = false;
					$output_array['message'] = $responce;
				}
			}else{
				http_response_code(403);
				$output_array['status'] = false;
				$output_array['message'] = "Your Account is temporarily locked!";
			}
		} else{
			http_response_code(500);
			$output_array['status'] = false;
			$output_array['message'] = $sql;
		}
	} else{
		http_response_code(400);
		$output_array['status'] = false;
		$output_array['message'] = "Bad request";
	}

	echo json_encode($output_array);
?>