<?php
    include("import.php");

    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

            // $sql = "SELECT * FROM user WHERE user_id='$user_id'";
            // $result = $conn->query($sql);
            // if($result->num_rows > 0){
            //     $row = $result->fetch_assoc();

                $reqsql = "SELECT * FROM blood_request WHERE user_id = '$user_id'";
                $reqresult = $conn->query($reqsql);
                if($reqresult->num_rows > 0){
                    $reqrow = $reqresult->fetch_assoc();
                    // $req_id = $reqrow['blood_request_id'];

                    $request_id = $reqrow['blood_request_id'];
                    $request_time = $reqrow['request_time'];

                    $currentTime = date('H:i:s');
                    $after_5_minutes = date('H:i:s', strtotime($request_time. '+ 5 minutes'));

                    if($after_5_minutes >= $currentTime){
                        $updateSql = "UPDATE blood_request SET blood_bank_status='1' WHERE blood_request_id='$request_id'";
						$updateResult = $conn->query($updateSql);

                        $sql = "SELECT * FROM blood_request WHERE blood_request_id='$request_id'";
						$result = $conn->query($sql);
						$row = $result->fetch_assoc();
						$blood_bank = $row['blood_bank_status'];
                    }

                    if(!empty($data->request_id)){
                        $req_id = $data->request_id;
                            $accSql ="SELECT * FROM rq_accept_reject a LEFT OUTER JOIN blood_donation b ON a.donor_id=b.user_id LEFT OUTER JOIN bloodlist c ON b.blood_group=c.blood_id LEFT OUTER JOIN user d ON b.user_id=d.user_id WHERE a.request_id ='$req_id'";
                            $accResult = $conn->query($accSql);
                            $i = 0;
                            if($accResult->num_rows > 0){
                                while($accRow = $accResult->fetch_assoc()){
                                    $output_array['GTS'][$i]['blood_donor_name'] = $accRow['blood_donor_name'];
                                    $output_array['GTS'][$i]['phone_number'] = $accRow['user_phone_number'];
                                    $output_array['GTS'][$i]['donor_alter_phone_no'] = $accRow['donor_alter_phone_no'];
                                    $output_array['GTS'][$i]['blood_group'] = $accRow['blood_name'];
                                    $output_array['GTS'][$i]['blood_donor_age'] = $accRow['blood_donor_age'];
                                    $output_array['GTS'][$i]['blood_donor_dob'] = $accRow['blood_donor_dob'];
                                    $output_array['GTS'][$i]['donor_address'] = $accRow['donor_address'];
                                    $output_array['GTS'][$i]['donor_height'] = $accRow['donor_height'];
                                    $output_array['GTS'][$i]['donor_weight'] = $accRow['donor_weight'];
                                    $i++;
                                    $output_array['status'] = true;
                                }
                                $output_array['blood_bank_status'] = $reqrow['blood_bank_status'];
                            }else{
                                http_response_code(200);
                                $output_array['GTS'] = [];
                                $output_array['blood_bank_status'] = $blood_bank;
					            $output_array['status'] = true;
					            $output_array['message'] = "Success Donors not Found !";
                            }
                    }else{
                        http_response_code(404);
                        $output_array['status'] = false;
                        $output_array['message'] = "Bad request";
                    }
                } else{
                    http_response_code(404);
					$output_array['status'] = false;
					$output_array['message'] = "Data not found";
                }
            // } else{
            //     http_response_code(404);
            //     $output_array['status'] = false;
            //     $output_array['message'] = "Data not found";
            // }
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