<?php
    include("import.php");

    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);
            
            $sql = "SELECT * FROM user WHERE user_id = '$user_id'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = mysqli_fetch_array($result);

                $rq_accept_reject_sql = "SELECT * FROM rq_accept_reject a LEFT OUTER JOIN blood_request b ON b.blood_request_id = a.request_id WHERE a.danated_status = '1' AND a.donor_id = '$user_id'";
                $rq_accept_reject_result = $conn->query($rq_accept_reject_sql);
                if($rq_accept_reject_result->num_rows > 0){
                    $i = 0;
                    while($rq_accept_reject_row = mysqli_fetch_array($rq_accept_reject_result)){
                        $output_array['GTS'][$i]['name'] = $row['user_name'];
                        $output_array['GTS'][$i]['date'] = $rq_accept_reject_row['accept_reject_date'];
                        $output_array['GTS'][$i]['hospital_location'] = $rq_accept_reject_row['hospital_location'];
                        $output_array['GTS'][$i]['blood_type'] = $rq_accept_reject_row['blood_type'];
                        $i++;
                    }
                    http_response_code(200);
                    $output_array['status'] = true;
                    $output_array['message'] = 'Success';
                }
                else{
                    http_response_code(404);
                    $output_array['status'] = true;
                    $output_array['message'] = 'No Accepted Requests !';
                }
            } else{
                http_response_code(404);
                $output_array['status'] = false;
                $output_array['message'] = "user not found";
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