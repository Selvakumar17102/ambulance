<?php
    function sendNotificationDelivery($to, $title, $msg, $img, $order_id, $order_status, $linkURL)
    {
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
            'app_id' => '7e282bb1-7d6a-4be7-a9cf-efbae6e38dc9',
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
            "data" => (object)array("order_id"=> $order_id,"order_status"=>"$order_status","type"=>0,"linkURL"=> $linkURL),
            "notification" => (object)array("order_id"=> $order_id,"order_status"=>"$order_status","type"=>0,"linkURL"=> $linkURL),
            "android_channel_id"=> "3a91c9c9-3074-4298-bb3b-92c20a8a1142"
        );
        // print_r($fields['include_external_user_ids']);
        $headers = array(
            'Authorization: Basic MjU2ZTYyNDgtOGM0Ni00ZGJkLTg5N2QtMTVkOGI3MjhmZDU1',
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

?>