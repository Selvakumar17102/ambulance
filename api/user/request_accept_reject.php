<?php
    include("import.php");
    include("../onesignaluser.php");

    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

            if(!empty($data->status) && !empty($data->request_id)){
                // $donor_id=$data->donor_id;
                $request_id=$data->request_id;
                $status=$data->status;
                $reason=$data->reason;
            
                $sql = "SELECT * FROM user WHERE user_id='$user_id'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $date = date('d-m-Y');
                    $insertSql = "INSERT INTO rq_accept_reject (donor_id,request_id,accept_reject_date,danated_status,reject_reason) VALUES('$user_id','$request_id','$date','$status','$reason')";
                    if($conn->query($insertSql)===TRUE){
                        $request_id = $conn->insert_id;
                        if($status == 1){
                            $msg = "Accepted";

                            $blood_req_sql = "SELECT * FROM blood_request WHERE blood_request_id = '$request_id'";
                            $blood_req_result = $conn->query($blood_req_sql);
                            if($blood_req_result->num_rows > 0){
                                $blood_req_row = $blood_req_result->fetch_assoc();
                                $req_id = $blood_req_row['user_id'];
                                $title = 'Hi '.$blood_req_row['patient_name'];
                                $res = sendNotificationUser($req_id, $title, "we found a donor for you", '', $request_id, '1');
                                
                            }

                            $blood_donation_sql = "SELECT * FROM blood_donation WHERE user_id = '$user_id'";
                            $blood_donation_result = $conn->query($blood_donation_sql);
                            if($blood_donation_result->num_rows > 0){
						    	$blood_donation_row = $blood_donation_result->fetch_assoc();
						    	$donor_id = $blood_donation_row['user_id'];
                    	    	$title = 'Hi '.$blood_donation_row['blood_donor_name'];
						    	$res = sendNotificationUser($donor_id, $title, "Blood Requested Accepted Successfully", '', $request_id, '1');
						    	
						    }

                        }elseif($status == 2){
                            $msg = "Rejected";

                            $blood_donation_sql = "SELECT * FROM blood_donation WHERE user_id = '$user_id'";
                            $blood_donation_result = $conn->query($blood_donation_sql);
                            if($blood_donation_result->num_rows > 0){
						    	$blood_donation_row = $blood_donation_result->fetch_assoc();
						    	$donor_id = $blood_donation_row['user_id'];
                    	    	$title = 'Hi '.$blood_donation_row['blood_donor_name'];
						    	$res = sendNotificationUser($donor_id, $title, "Blood Requested Rejected Successfully", '', $request_id, '1');
						    	
						    }
                        }
                        http_response_code(200);
                        $output_array['status'] = true;
                        $output_array['message'] = $msg;
                    }
                } else{
                    http_response_code(404);
                    $output_array['status'] = false;
                    $output_array['message'] = "user not found";
                }
            }else{
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