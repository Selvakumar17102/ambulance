<?php
    include("import.php");

    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

            if(!empty($data->order_id)){
                $order_id = $data->order_id;

                $sql = "SELECT * FROM orders WHERE order_id='$order_id'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                $order_string = $row['order_string'];
                $login_id = $row['login_id'];
                $amount = $row['total_amount'] * 100;

                $sql = "SELECT * FROM branch WHERE login_id='$login_id'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                $url = "https://api.razorpay.com/v1/orders";

                $arrayToSend = array("amount"=> $amount,"currency"=> "INR","receipt"=> $order_string);
                $json = json_encode($arrayToSend);
                
                $headers = array();
                $headers[] = 'Content-Type: application/json';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
                curl_setopt($ch, CURLOPT_USERPWD, $row['razorpay_merchant_key'].":".$row['razorpay_merchant_id']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

                $output_array['GTS'] = json_decode(curl_exec($ch));
                $output_array['status'] = true;
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