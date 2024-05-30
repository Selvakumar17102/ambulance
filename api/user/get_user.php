<?php
    include("import.php");
    ini_set('display_errors','off');

    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

            $sql = "SELECT * FROM user WHERE user_id='$user_id' AND user_status='1'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();

                $checkSql = "SELECT * FROM `blood_donation` WHERE user_id='$user_id'";
                $checkReult = $conn->query($checkSql);
                $donorRow = $checkReult->fetch_assoc();
                if($checkReult->num_rows > 0){
                    $donor_status = "1";
                }else{
                    $donor_status = "0";
                }

                $output_array['GTS']['user_id'] = (int)$row['user_id'];
                $output_array['GTS']['name'] = $row['user_name'];
                if($row['user_profile']){
                    $output_array['GTS']['profile_image'] = $IMAGE_BASE_URL.$row['user_profile'];
                } else{
                    $output_array['GTS']['profile_image'] = "";
                }

                switch ($row['blood_group']) {
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
                $output_array['GTS']['mobile_number'] = $row['user_phone_number'];
                $output_array['GTS']['user_alternate_phone_number'] = $row['user_alternate_phone_number'];
                $output_array['GTS']['email_id'] = $row['user_email'];
                $output_array['GTS']['blood_group'] = $bloodname;
                $output_array['GTS']['bp_level'] = (int)$row['bp_level'];
                $output_array['GTS']['sugar'] = (int)$row['sugar_level'];
                $output_array['GTS']['thyroid'] = (int)$row['thyroid'];
                $output_array['GTS']['asthma'] = (int)$row['asthma'];
                $output_array['GTS']['is_donor'] = $donor_status;
                $output_array['GTS']['last_donation_date'] = $donorRow['last_time_donated_date'];



                $output_array['status'] = true;
            } else{
                http_response_code(404);
				$output_array['status'] = false;
				$output_array['message'] = "Data not found";
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