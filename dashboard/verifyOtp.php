<?php
    include('include/connection.php');
    session_start();

    $sql = "SELECT * FROM login WHERE login_id='1'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $Otp = $_SESSION['otp'];
    if(isset($_POST['verify'])){
        $otp = $_POST['otp'];

        if($otp == $Otp){
            $_SESSION['check'] = 1;
            unset($_SESSION['otp']);
            header('Location: forgotPassword.php');
        } else {
            header('Location: verifyOtp.php?err=Invalid OTP!');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Otp Verification | Salvo Ambulance</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
</head>
<body class="form" style="background-color: #E91E63">
    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <img style="width: 150px" src="assets/img/main_logo.png" alt="">
                        <h1 class="">OTP Verification</h1>
                        <p id="Message" style="margin-bottom: 0px">Otp has been sent to +91 *******<?php echo substr($row['login_phone_number'], -3) ?></p>
                        <form class="text-left" method="post">
                            <div class="form">
                                <div id="username-field" class="field-wrapper input">
                                    <label for="otp">OTP</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="otp" name="otp" type="text" class="form-control" autocomplete="off" placeholder="OTP" required>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" name="verify" class="btn btn-primary">Verify</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/manual.js"></script>
    <script src="assets/js/authentication/form-2.js"></script>
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>
</body>
</html>