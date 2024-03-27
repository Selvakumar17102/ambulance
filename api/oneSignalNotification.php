<?php
    function oneSignalNotification($to, $title, $message, $img, $url, $category_id,$type)
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
            'priority' => 10,
            'url' => "$url",
            "data" => (object)array("order_id"=> 0,"order_status"=> 0,"type"=>"$type","category_id"=>"$category_id"),
            "notification" => (object)array("order_id"=> 0,"order_status"=> 0,"type"=>"$type","category_id"=>"$category_id"),
            "android_channel_id" => "66ef23af-46a6-42e0-8751-73bf2f1d05a6"
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

    // $res = sendnotification("541",'HI',"HRU",'','123','1');
    // echo $res;
?>