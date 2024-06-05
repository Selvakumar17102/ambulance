<?php
    include("dashboard/include/connection.php");
    include("api/distance-calculator.php");
    include("api/onesignaluser.php");
    include("api/actiononesignaluser.php");
    include("api/onesignaldelivery.php");
    ini_set('display_errors','on');
	date_default_timezone_set("Asia/Calcutta");

    $currentTime = date('H:i:s');

    $blood_request_sql = "SELECT * FROM blood_request WHERE status = '0'";
    $blood_request_result = $conn->query($blood_request_sql);
    if($blood_request_result->num_rows > 0){
        // echo "jjjj"; exit();
        while($blood_request_row = $blood_request_result->fetch_assoc()){
            $blood_request_id = $blood_request_row['blood_request_id'];
            $request_time = $blood_request_row['request_time'];
            $blood_group = $blood_request_row['blood_group'];

            $after_five_minutes = date('H:i:s', strtotime($request_time. " +5 minutes"));
            $after_ten_minutes = date('H:i:s', strtotime($request_time. " +10 minutes"));

            if($after_5_minutes <= $currentTime){
                $blood_donation_sql = "SELECT * FROM blood_donation WHERE blood_group != '$blood_group'";
                $blood_donation_result = $conn->query($blood_donation_sql);
                if($blood_donation_result->num_rows > 0){
					while($blood_donation_row = $blood_donation_result->fetch_assoc()){
						$donor_id = $blood_donation_row['user_id'];
                		$title = 'Hi '.$blood_donation_row['blood_donor_name'];
						$res = sendNotificationUser($donor_id, $title, "Urgent Need .'$blood_group'. Blood !", '', $blood_request_id, '1');
                        $res = actionsendNotificationUser($donor_id, $title, "Urgent Need .'$blood_group'. Blood !", '', $blood_request_id, '1');
					}
				}
            }elseif($after_10_minutes <= $currentTime){
                $blood_donation_sql = "SELECT * FROM blood_donation WHERE blood_group != '$blood_group'";
                $blood_donation_result = $conn->query($blood_donation_sql);
                if($blood_donation_result->num_rows > 0){
					while($blood_donation_row = $blood_donation_result->fetch_assoc()){
						$donor_id = $blood_donation_row['user_id'];
                		$title = 'Hi '.$blood_donation_row['blood_donor_name'];
						$res = sendNotificationUser($donor_id, $title, "Urgent Need .'$blood_group'. Blood !", '', $blood_request_id, '1');
                        $res = actionsendNotificationUser($donor_id, $title, "Urgent Need .'$blood_group'. Blood !", '', $blood_request_id, '1');
					}
				}
            }elseif($currentTime == $after_ten_minutes){
                $bloodRequest_update_sql = "UPDATE blood_request SET blood_bank_status = '1' WHERE blood_request_id = '$blood_request_id'";
                $conn->query($bloodRequest_update_sql);
            }
        }
    }

    $order_sql = "SELECT * FROM orders WHERE order_status = '1'";
    $order_result = $conn->query($order_sql);
    if($order_result->num_rows > 0){
        while($order_row = $order_result->fetch_assoc()){
            $order_id = $order_row['order_id'];
            $ambulance_notification_status = $order_row['ambulance_notification_status'];
            $pickup_latitude = $order_row['pickup_latitude'];
            $pickup_longitude = $order_row['pickup_longitude'];

            $delivery_partner_sql = "SELECT * FROM delivery_partner WHERE delivery_partner_online_status = '1' AND delivery_partner_status = '1'";
            $delivery_partner_result = $conn->query($delivery_partner_sql);
            if($delivery_partner_result->num_rows > 0){
                $deliveryPartners = []; // Initialize an empty array to store delivery partners

                while($delivery_partner_row = $delivery_partner_result->fetch_assoc()){
                    $deliveryPartners[] = [
                        'id' => $delivery_partner_row['delivery_partner_id'],
                        'delivery_partner_name' => $delivery_partner_row['delivery_partner_name'],
                        'latitude' => $delivery_partner_row['delivery_partner_latitude'],
                        'longitude' => $delivery_partner_row['delivery_partner_longitude'],
                    ];
                }
                
                foreach($deliveryPartners as &$partner){
                    $partner['distance'] = getDistance($pickup_latitude, $pickup_longitude, $partner['latitude'], $partner['longitude']);
                }
                
                unset($partner); // Unset the reference to avoid accidental modification

                usort($deliveryPartners, function ($a, $b) {
                    return $a['distance'] <=> $b['distance']; // Compare distances
                });

                $start_count = $ambulance_notification_status * 3;

                // Get the details of the nearest 3 delivery partners
                $nearestDeliveryPartners = array_slice($deliveryPartners, $start_count, 3);

                foreach($nearestDeliveryPartners as $partner){
                    $ambulance_id = $partner['id'];
                    $delivery_partner_name = $partner['delivery_partner_name'];
                    $driverTitle = "Hi ".$delivery_partner_name;
                    $res = sendNotificationDelivery($ambulance_id, $driverTitle, "New Booking !", '', $order_id, '1', '');
                }
                $new_ambulance_notification_status = $ambulance_notification_status + 1;

                if($res){
                    $order_update_sql = "UPDATE orders SET ambulance_notification_status = '$new_ambulance_notification_status' WHERE order_id = '$order_id'";
                    $conn->query($order_update_sql);
                }
            }
        }
    }
?>
