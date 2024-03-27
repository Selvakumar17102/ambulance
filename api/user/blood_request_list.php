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

                $donorsql = "SELECT * FROM blood_donation a LEFT OUTER JOIN bloodlist b ON a.blood_group = b.blood_id WHERE user_id = '$user_id'";
                $donorresult = $conn->query($donorsql);
                if($donorresult->num_rows > 0){
                    $donorrow = $donorresult->fetch_assoc();

                    $donarlat = $donorrow['donor_latitude'];
                    $donarlong = $donorrow['donor_longitude'];

                    $bloodgrp = $donorrow['blood_group'];

                    $reqSql ="SELECT *, a.request_reason AS requestReason FROM blood_request a LEFT OUTER JOIN bloodlist b ON a.blood_group = b.blood_id LEFT OUTER JOIN request_reason c ON c.reason_id = a.request_reason WHERE a.blood_group = '$bloodgrp'";
                    $reqResult = $conn->query($reqSql);
                    $i = 0;
                    if($reqResult->num_rows > 0){
                        while($reqRow = $reqResult->fetch_assoc()){

                            $reqlat = $reqRow['latitude'];
                            $reqlong = $reqRow['longitude'];

                            $appsql = "SELECT * FROM `blood_app_control`";
                            $appResult = $conn->query($appsql);
                            $approw =$appResult->fetch_assoc();

                            $km = round(getDistance($donarlat,$donarlong,$reqlat,$reqlong));
                            if($km < (int)$approw['request_km']){

                                if($reqRow['emergency_status'] == 1){
                                    $eStatus = "Emergency";
                                }else{
                                    $eStatus = "Non-Emergency";
                                }
                                $reqId = $reqRow['blood_request_id'];

                                $checkSql = "SELECT * FROM rq_accept_reject WHERE donor_id = '$user_id' AND request_id='$reqId'";
                                $checkresult = $conn->query($checkSql);
                                if($checkresult->num_rows > 0){
                                    $status = "1";
                                }else{
                                    $status = "0";
                                }

                                // $reason_id = $reqRow['request_reason'];
                                // if($reqRow['request_reason'] == 1){
                                //     $blood_req_sql = "SELECT * FROM request_reason_list WHERE request_id = '$reqId'";
                                //     $blood_req_result = $conn->query($blood_req_sql);
                                //     $blood_req_row = mysqli_fetch_array($blood_req_result);
                                //     $request_reason = $blood_req_row['reason'];
                                // }
                                // else{
                                //     $blood_req_sql = "SELECT * FROM request_reason WHERE reason_id = '$reason_id'";
                                //     $blood_req_result = $conn->query($blood_req_sql);
                                //     $blood_req_row = mysqli_fetch_array($blood_req_result);
                                //     $request_reason = $blood_req_row['reason'];
                                // }
                                
                                $output_array['GTS'][$i]['blood_request_id'] = $reqRow['blood_request_id'];
                                $output_array['GTS'][$i]['patient_name'] = $reqRow['patient_name'];
                                $output_array['GTS'][$i]['age'] = $reqRow['age'];
                                $output_array['GTS'][$i]['blood_type'] = $reqRow['blood_type'];
                                $output_array['GTS'][$i]['blood_group'] = $reqRow['blood_name'];
                                $output_array['GTS'][$i]['phone_number'] = $reqRow['phone_no'];
                                $output_array['GTS'][$i]['alter_phone_no'] = $reqRow['alter_phone_no'];
                                $output_array['GTS'][$i]['request_date'] = $reqRow['request_date'];
                                $output_array['GTS'][$i]['unit'] = $reqRow['unit'];
                                $output_array['GTS'][$i]['hospital_location'] = $reqRow['hospital_location'];
                                $output_array['GTS'][$i]['latitude'] = $reqRow['latitude'];
                                $output_array['GTS'][$i]['longitude'] = $reqRow['longitude'];
                                $output_array['GTS'][$i]['request_reason'] = $reqRow['requestReason'];
                                $output_array['GTS'][$i]['required_date'] = $reqRow['required_date'];
                                $output_array['GTS'][$i]['emergency_status'] = $eStatus;
                                $output_array['GTS'][$i]['status'] = $status;
                            }

                            $i++;

                            $output_array['status'] = true;
                        }
                    }else{
                        http_response_code(404);
					    $output_array['status'] = false;
					    $output_array['message'] = "Request not found";
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