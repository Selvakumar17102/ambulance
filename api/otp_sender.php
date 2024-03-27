<?php
    function SendOTP($phone,$msg,$otp){
        $authKey = '393703AsW3DyhfhvYb64268496P1';
        $sender = 'GTSSMS';
        $dltId = '1207161855329572829';

        $url = "https://control.msg91.com/api/sendotp.php?authkey=$authKey&mobile=$phone&message=$msg&sender=$sender&otp=$otp&DLT_TE_ID=$dltId";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $responce = curl_exec($ch);

        return json_decode($responce);
    }
?>