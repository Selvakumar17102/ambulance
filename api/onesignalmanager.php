<?php
    // function sendNotificationManager($to, $title, $message, $img, $order_id, $order_status)
    // {
    //     $msg = $message;
    //     $content = array(
    //         "en" => $msg
    //     );
    //     $headings = array(
    //         "en" => $title
    //     );
        
    //     $ios_img = array(
    //         "id1" => $img
    //     );
    //     $fields = array(
    //         'app_id' => '4f078602-3f57-4c86-9a65-827b27f68297',
    //         "headings" => $headings,
    //         'include_external_user_ids' => array($to),
    //         "channel_for_external_user_ids" => "push",
    //         'contents' => $content,
    //         'android_sound' =>'notification',
    //         "big_picture" => $img,
    //         'small_icon' => "notify_icon",
    //         'large_icon' => "https://instantambulance.in/dashboard/assets/img/favicon.ico",
    //         'content_available' => true,
    //         "ios_attachments" => $ios_img,
    //         'priority' => 10,
    //         "data" => (object)array("order_id"=> $order_id,"order_status"=>"$order_status","type"=>0),
    //         "notification" => (object)array("order_id"=> $order_id,"order_status"=>"$order_status","type"=>0),
    //         "android_channel_id" => "e5cbe46e-c33c-4cdb-9ceb-60c3fd05ad5b"
    //     );

        
    //     $headers = array(
    //         'Authorization: Basic OTNlOGY4YTgtNTg0MC00Njc1LWE2ZWEtMjZjZTFhMTZiZWVh',
    //         'Content-Type: application/json; charset=utf-8'
    //     );
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    //     $result = curl_exec($ch);
    //     curl_close($ch);
    //     return $result;
    // }

    // $res = sendnotification("541",'HI',"HRU",'','123','1');
    // echo $res;
?>