<?php
    include("include/connection.php");
    include("../api/otp_sender.php");
    session_start();

    $randomid = mt_rand(1000,9999);
    $msg = "Your Instant Ambulance verification OTP is ".$randomid.".";
    $msg = urlencode($msg);

    $sql = "SELECT * FROM login WHERE login_id='1'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $phone = '91'.$row['login_phone_number'];

    $responce = SendOTP($phone,$msg,$randomid);
    if($responce->type == 'success'){
        $_SESSION['otp'] = $randomid;
        $sql = "UPDATE login SET login_otp='$randomid' WHERE login_id='1'";
        if($conn->query($sql) === TRUE){
            header("Location: verifyOtp.php");
        }
    } else {
        var_dump($responce);
    }
?>