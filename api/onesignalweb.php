<?php
    function sendnotification($to, $title, $message, $img)
    {
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
            'app_id' => '3d3e2345-f811-40e9-8be3-a23c566e4d99',
            "headings" => $headings,
            'include_external_user_ids' => array($to),
            'contents' => $content,
            'android_sound' =>'notification',
            "big_picture" => $img,
            'large_icon' => "https://Instant Ambulance/assets/images/notify_image.png",
            'content_available' => true,
            "ios_attachments" => $ios_img,
            "priority" => 10,
        );

        
        $headers = array(
            'Authorization: Basic NzdhNjQ0ZjMtNWYxNi00ZGE0LTkwNmUtMTFlMmE0MTYzZTNm',
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