<?php
    function generatePass($conn,$newPass){
        $sql = "SELECT * FROM app_control WHERE app_control_id='1'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $key = $row['cipher_key'];
        $ciphering = "AES-128-CTR";
        $option = 0;
        $cipher = rand(1111111111111111,9999999999999999);

        $encrypted = openssl_encrypt($newPass,$ciphering,$key,$option,$cipher);

        $out['password'] = $encrypted;
        $out['cipher'] = $cipher;

        return json_encode($out);
    }
    function chechPass($conn,$oldPass,$cipher,$newPass){
        $sql = "SELECT * FROM app_control WHERE app_control_id='1'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $decryption_key = $row['cipher_key'];
        $ciphering = "AES-128-CTR";
        $option = 0;

        $decrypted = openssl_decrypt($oldPass,$ciphering,$decryption_key,$option,$cipher);

        if($decrypted == $newPass){
            return TRUE;
        } else{
            return FALSE;
        }
    }
?>