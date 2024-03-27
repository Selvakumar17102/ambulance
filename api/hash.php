<?php
    function generateHash($conn,$data){
        $sql = "SELECT * FROM app_control WHERE app_control_id='1'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $key = $row['salt_key'];
        $ciphering = "AES-128-CTR";
        $option = 0;
        $cipher = rand(1111111111111111,9999999999999999);

        $hashValue = openssl_encrypt($data,$ciphering,$key,$option,$cipher);

        $out['hashValue'] = $hashValue;
        $out['cipher'] = $cipher;

        return json_encode($out);
    }
    function degenerateHash($conn,$data,$cipher){
        $sql = "SELECT * FROM app_control WHERE app_control_id='1'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $key = $row['salt_key'];
        $ciphering = "AES-128-CTR";
        $option = 0;

        $decrypted = openssl_decrypt($data,$ciphering,$key,$option,$cipher);

        $res['status'] = 1;
        $res['data'] = json_decode($decrypted);

        return $res;
    }
?>