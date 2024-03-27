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

            $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$user_id'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();

                $delivery_partner_latitude = $row['delivery_partner_latitude'];
                $delivery_partner_longitude = $row['delivery_partner_longitude'];

                $sql = "SELECT * FROM orders WHERE delivery_partner_id='$user_id' AND order_status!='0'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $completed = $cod = $onlinePayment = $active = $totalAmount = $clientAmount = $travelKm = 0;
                    while($row = $result->fetch_assoc()){
                        if($row['order_status'] == 7){
                            $travelDis = preg_replace('/[^0-9]/', '', $row['travel_distance']);
                            $travelKm += $travelDis;

                            $totalAmount += $row['total_amount'];
                            $clientAmount += $row['amount_for_client'];
                            $completed++;
                            if($row['payment_type'] == 'Cash On Hand'){
                                $cod++;
                            } else{
                                $onlinePayment++;
                            }
                        } else{
                            $active++;
                        }
                    }

                    $output_array['GTS']['overall_earning'] = (int)$totalAmount;
                    $output_array['GTS']['my_earning'] = (int)($totalAmount - $clientAmount);
                    $output_array['GTS']['completed'] = $completed;
                    $output_array['GTS']['km_travelled'] = $travelKm;
                    $output_array['GTS']['cash_on_delivery'] = $cod;
                    $output_array['GTS']['online_payment'] = $onlinePayment;
                    $output_array['GTS']['active'] = $active;

                    $output_array['status'] = true;
                } else{
                    http_response_code(404);
                    $output_array['status'] = false;
                    $output_array['message'] = 'Order not found';
                }
            } else{
                http_response_code(404);
                $output_array['status'] = false;
                $output_array['message'] = 'Delivery partner not found';
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