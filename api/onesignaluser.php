<?php
    function sendNotificationUser($to, $title, $message, $img, $order_id, $order_status)
    {
        $to = (string)$to;
        $msg = $message;
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
            'app_id' => '445d6ab9-c0ae-4aab-b802-992d0c1a4b0c',
            "headings" => $headings,
            'include_external_user_ids' => array($to),
            "channel_for_external_user_ids" => "push",
            "isIos" => true,
            "isAndroid" => true,
            'contents' => $content,
            'android_sound' =>'notification',
            "big_picture" => $img,
            'small_icon' => "notify_icon",
            'large_icon' => "https://instantambulance.in/dashboard/assets/img/favicon.ico",
            'content_available' => true,
            "ios_attachments" => $ios_img,
            'priority' => 10,
            "data" => (object)array("order_id"=> $order_id,"order_status"=>"$order_status","type"=>0,"category_id"=>0),
            "notification" => (object)array("order_id"=> $order_id,"order_status"=>"$order_status","type"=>0,"category_id"=>0),
            "android_channel_id" => "f460dc8d-88a2-49ba-8a1f-4f691e6b96f7"
        );

        
        $headers = array(
            'Authorization: Basic YzM2MTNiMjktOWQ1ZS00NDU0LWJjMWQtMDZkYjdlY2FjZTI4',
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

    // $res = sendNotificationUser("1",'HI',"HRU",'','123','1');
    // echo $res;
?>