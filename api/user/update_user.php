<?php
    include("import.php");

    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);
            
            if($user_id){
                $user_name = $_POST["name"];
                $mobile_number = $_POST["mobile_number"];
                $user_alternate_phone_number = $_POST["user_alternate_phone_number"];
                $user_email = $_POST["email_id"];
                $blood_group = mysqli_real_escape_string($conn, $_POST["blood_group"]);
                $bp_level = $_POST["bp_level"];
                $sugar_level = $_POST["sugar"];
                // $hypertention = $_POST["hypertention"];
                // $diabetes = $_POST["diabetes"];
                $thyroid = $_POST["thyroid"];
                $asthma = $_POST["asthma"];
                $image = $_FILES['image'];

                $sql = "SELECT * FROM user WHERE user_id='$user_id'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $sql = "UPDATE user SET user_name='$user_name',user_email='$user_email',user_alternate_phone_number='$user_alternate_phone_number',blood_group='$blood_group',bp_level='$bp_level',sugar_level='$sugar_level',thyroid='$thyroid',asthma='$asthma' WHERE user_id='$user_id'";
                    // $sql = "UPDATE user SET user_name='$user_name',user_email='$user_email',user_alternate_phone_number='$user_alternate_phone_number',blood_group='$blood_group',hypertention='$hypertention',diabetes='$diabetes',thyroid='$thyroid',asthma='$asthma' WHERE user_id='$user_id'";
                    if($conn->query($sql) === TRUE){

                        $type = Pathinfo($image['name'],PATHINFO_EXTENSION);
                        $path = "Images/UserProfile/$user_id.$type";
                        $ImagePath = "../../dashboard/$path";

                        if(move_uploaded_file($image["tmp_name"], $ImagePath)){
                            $sql = "UPDATE user SET user_profile='$path' WHERE user_id='$user_id'";
                            $conn->query($sql);
                        }

                        http_response_code(200);
                        $output_array['status'] = true;
                        $output_array['message'] = 'Ok';
                    } else{
                        http_response_code(500);
                        $output_array['status'] = false;
                        $output_array['query'] = $sql;
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
            $output_array['message'] = "Invalid Authentication";
		}
	} else{
		http_response_code(401);
        $output_array['status'] = false;
        $output_array['message'] = "Authentication Missing";
	}

    echo json_encode($output_array);
?>