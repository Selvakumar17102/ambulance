<?php
    include("import.php");

    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

            $sql = "SELECT * FROM user WHERE user_id='$user_id'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $sql1 = "SELECT * FROM orders WHERE user_id='$user_id' AND order_status!='0'";
                // $sql1 = "SELECT * FROM orders WHERE user_id='$user_id' AND order_status!='0' AND order_status!='5'";
                $result1 = $conn->query($sql1);
                if($result1->num_rows > 0){
                    while ($row = $result1->fetch_assoc()) {
                        $orderstatus = $row['order_status'];
                        if ($orderstatus ==1) {
                                $msg = "Your booking has been confirmed. Stay strong..!!";
                        }elseif($orderstatus == 2){
                            $msg = "An ambulance driver has accepted your request.";
                        }elseif($orderstatus == 4){
                            $msg = "Help is on the way. Stay calm and hopeful";
                        }elseif($orderstatus == 5){
                            $msg = "The ambulance has reached the spot. Everything will be ok";
                        }

                        if($msg != NULL){
                            http_response_code(200);
                            $output_array['status'] = true;
                            $output_array['message'] = "ok";
                            $output_array['ambulance_status'] = $msg;
                        }else{
                            http_response_code(404);
					        $output_array['status'] = false;
					        $output_array['message'] = "Data not found";
					        $output_array['ambulance_status'] = "NULL";
                        }
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