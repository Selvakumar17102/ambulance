<?php
    include("../../dashboard/include/connection.php");
    include("../distance-calculator.php");
    include("../code.php");
    date_default_timezone_set("Asia/Calcutta");

    $date = date('Y-m-d');
	$time = date('H:i:s');

    $output_array = array();

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->user_id)){
        $user_id = $data->user_id;
        $order_id = $data->order_id;
        $latitude = $data->latitude;
        $longitude = $data->longitude;

        $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$user_id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $sql = "SELECT * FROM orders WHERE delivery_partner_id='$user_id' AND order_id='$order_id'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();

                $user_latitude = $row['user_latitude'];
                $user_longitude = $row['user_longitude'];
                $order_status = $row['order_status'];
                $customer_id = $row['user_id'];

                $sql = "SELECT user_name FROM user WHERE user_id='$customer_id'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                $user_name = $row['user_name'];

                $km = round(getDistance($latitude,$longitude,$user_latitude,$user_longitude),2);

                if ($km <= 1){
                    function sendDPArrivedNotification($to, $title, $msg, $img, $order_id, $order_status){
                        $to = (string)$to;
                        $content = array(
                            "en" => $msg
                        );
                        $headings = array(
                            "en" => $title
                        );
                        
                        $ios_img = array(
                            "id1" => $img
                        );
                        $fields = array(
                            'app_id' => 'e12d9055-5884-4554-84ac-3ef7f9136833',
                            "headings" => $headings,
                            'include_external_user_ids' => array($to),
                            "channel_for_external_user_ids" => "push",
                            'contents' => $content,
                            'android_sound' =>'notification',
                            "big_picture" => $img,
                            'small_icon' => "notify_icon",
                            'large_icon' => "https://instantambulance.in/dashboard/assets/img/favicon.ico",
                            'content_available' => true,
                            "ios_attachments" => $ios_img,
                            "priority" => 10,
                            "data" => (object)array("order_id"=> $order_id,"order_status"=>"$order_status","type"=>0,"category_id"=>0),
                            "android_channel_id"=> "66ef23af-46a6-42e0-8751-73bf2f1d05a6"
                        );
                        $headers = array(
                            'Authorization: Basic M2Q3N2I4MzAtYzdlNy00MTUxLWIzMGQtY2I2N2JiYzBmZmNl',
                            'Content-Type: application/json; charset=utf-8'
                        );
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                        $result = curl_exec($ch);
                        curl_close($ch);
                        return $result;
                    }

                    $title = 'Hi '.$user_name;

                    $res = sendDPArrivedNotification($customer_id, $title, 'Delivery Partner arrived at your location','',$order_id, $order_status);

                    $sql = "UPDATE orders SET delivery_partner_arrived_notification='1',delivery_partner_arrived_time='$time' WHERE order_id='$order_id'";
                    $conn->query($sql);
                } else{
                    header($inValid);
                    $output_array['status'] = false;
                    $output_array['message'] = 'Not in range';
                }
            } else{
                header($notFound);
                $output_array['status'] = false;
                $output_array['message'] = 'Order not found';
            }
        } else{
            header($inValid);
            $output_array['status'] = false;
            $output_array['message'] = 'Delivery partner not found';
        }
    } else{
        header($badRequest);
        $output_array['status'] = false;
        $output_array['message'] = 'Bad Request';
    }

    echo json_encode($output_array);
?>