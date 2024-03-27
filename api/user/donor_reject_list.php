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
                    $req_id = $reqrow['blood_request_id'];

                    $accSql ="SELECT * FROM rq_accept_reject a LEFT OUTER JOIN blood_donation b ON a.donor_id=b.user_id WHERE a.request_id ='$req_id' AND a.danated_status ='2'";
                    $accResult = $conn->query($accSql);
                    $i = 0;
                    if($accResult->num_rows > 0){
                        while($accRow = $accResult->fetch_assoc()){

                            $output_array['GTS'][$i]['blood_donor_name'] = $accRow['blood_donor_name'];
                            $output_array['GTS'][$i]['reject_reason'] = $accRow['reject_reason'];
                            $i++;

                            $output_array['status'] = true;
                        }
                    }else{
                        http_response_code(404);
					    $output_array['status'] = false;
					    $output_array['message'] = "Reject data not found";
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