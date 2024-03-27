<?php
    // ini_set('display_errors','off');
    include('include/connection.php');
    $setting = 'active';
    $settingShow = 'show';
    $settingBoolean = 'true';
    $control = 'active';

    if(isset($_POST['add'])){
        $minimum_order = $_POST['minimum_order'];
        $order_distance = $_POST['order_distance'];
        $best_selling_count = $_POST['best_selling_count'];
        $cart_count = $_POST['cart_count'];
        $app_intime = $_POST['app_intime'];
        $app_outtime = $_POST['app_outtime'];
        $delivery_charge = $_POST['delivery_charge'];
        $upto_distance = $_POST['upto_distance'];
        $increment = $_POST['increment'];
        $otp_message = $_POST['otp_message'];
        $referral_parent_payment = $_POST['referral_parent_payment'];
        $referral_child_payment = $_POST['referral_child_payment'];
        $minimum_convertible_points = $_POST['minimum_convertible_points'];
        $minimum_purchase_amount = $_POST['minimum_purchase_amount'];
        $minimum_purchase_points = $_POST['minimum_purchase_points'];
        $minimum_points = $_POST['minimum_points'];
        $service_not_available_content = $_POST['service_not_available_content'];
        $instant_order_closing_time = $_POST['instant_order_closing_time'];

        $youtube_url = $_POST['youtube_url'];
        $facebook_url = $_POST['facebook_url'];
                                        
        $instagram_url = $_POST['instagram_url'];
        $linkedin_url = $_POST['linkedin_url'];

        // $loginscreen_image = $_POST['loginscreen_image'];
        // $wallet_banner = $_POST['wallet_banner'];
        // $splash_image = $_POST['splash_image'];
        
        $splash_image = $_FILES['splash_image']['name'];
        $loginscreen_image = $_FILES['loginscreen_image']['name'];
        $wallet_banner = $_FILES['wallet_banner']['name'];

        $membership_image = $_FILES['membership_image']['name'];
        $mt_way_image = $_FILES['mt_way_image']['name'];
        $referral_image = $_FILES['referral_image']['name'];
        $mt_deals_image = $_FILES['mt_deals_image']['name'];
        $mt_deals_icon = $_FILES['mt_deals_icon']['name'];
        $upi_qr_code = $_FILES['upi_qr_code']['name'];

        $instant_delivery = $_POST['instant_delivery'];

        $sql = "UPDATE app_control SET linkedin_url='$linkedin_url',instagram_url='$instagram_url',youtube_url='$youtube_url',facebook_url='$facebook_url',instant_service_time='$instant_delivery',referral_parent_payment='$referral_parent_payment',referral_child_payment='$referral_child_payment',app_intime='$app_intime',app_outtime='$app_outtime',minimum_order='$minimum_order',order_distance='$order_distance',best_selling_count='$best_selling_count',cart_count='$cart_count',delivery_charge='$delivery_charge',upto_distance='$upto_distance',increment='$increment',otp_message='$otp_message',minimum_convertible_points='$minimum_convertible_points',minimum_purchase_amount='$minimum_purchase_amount',minimum_purchase_points='$minimum_purchase_points',minimum_points='$minimum_points',service_not_available_content='$service_not_available_content',instant_order_closing_time='$instant_order_closing_time' WHERE app_control_id='1'";
        if($conn->query($sql) === TRUE){
            
            $sql = "SELECT * FROM app_control WHERE app_control_id='1'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            
            if($wallet_banner){
                if(is_file($row['wallet_banner'])){
                    $wallety_banner = $row['wallet_banner'];
                }
                $type=pathinfo($_FILES['wallet_banner']['name'],PATHINFO_EXTENSION);

                $randomid = mt_rand(100,99999);
                $path="Images/Category/$randomid.$type";
                $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG');
                if(in_array($type, $allowTypes)){
                    if(move_uploaded_file($_FILES["wallet_banner"]["tmp_name"], $path)){
                        $sql2 = "UPDATE app_control SET wallet_banner = '$path' WHERE app_control_id='1'";
                        $conn->query($sql2);
                        unlink($wallety_banner);
                        // header('Location: control.php?msg=Controls updated!');
                    } 
                }
            }

            if($membership_image){
                if(is_file($row['membership_image'])){
                    $membershipp_image = $row['membership_image'];
                }
                $type=pathinfo($_FILES['membership_image']['name'],PATHINFO_EXTENSION);

                $randomid = mt_rand(100,99999);
                $path="Images/Category/$randomid.$type";
                $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG');
                if(in_array($type, $allowTypes)){
                    if(move_uploaded_file($_FILES["membership_image"]["tmp_name"], $path)){
                        $sql2 = "UPDATE app_control SET membership_image = '$path' WHERE app_control_id='1'";
                        $conn->query($sql2);
                        unlink($membershipp_image);
                        // header('Location: control.php?msg=Controls updated!');
                    } 
                }
            }

            if($upi_qr_code){
                if(is_file($row['upi_qr_code'])){
                    $upi_qrr_code = $row['upi_qr_code'];
                }
                $type=pathinfo($_FILES['upi_qr_code']['name'],PATHINFO_EXTENSION);

                $randomid = mt_rand(100,99999);
                $path="Images/Category/$randomid.$type";
                $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG');
                if(in_array($type, $allowTypes)){
                    if(move_uploaded_file($_FILES["upi_qr_code"]["tmp_name"], $path)){
                        $sql2 = "UPDATE app_control SET upi_qr_code = '$path' WHERE app_control_id='1'";
                        $conn->query($sql2);
                        unlink($upi_qrr_code);
                        // header('Location: control.php?msg=Controls updated!');
                    } 
                }
            }

            if($mt_way_image){
                if(is_file($row['mt_way_image'])){
                    $mt_wayy_image = $row['mt_way_image'];
                }
                $type=pathinfo($_FILES['mt_way_image']['name'],PATHINFO_EXTENSION);

                $randomid = mt_rand(100,999989);
                $path="Images/Category/$randomid.$type";
                $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG');
                if(in_array($type, $allowTypes)){
                    if(move_uploaded_file($_FILES["mt_way_image"]["tmp_name"], $path)){
                        $sql2 = "UPDATE app_control SET mt_way_image = '$path' WHERE app_control_id='1'";
                        $conn->query($sql2);
                        unlink($mt_wayy_image);
                        // header('Location: control.php?msg=Controls updated!');
                    } 
                }
            }

            if($referral_image){
                if(is_file($row['referral_image'])){
                    $referrall_image = $row['referral_image'];
                }
                $type=pathinfo($_FILES['referral_image']['name'],PATHINFO_EXTENSION);

                $randomid = mt_rand(100,999989);
                $path="Images/Category/$randomid.$type";
                $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG');
                if(in_array($type, $allowTypes)){
                    if(move_uploaded_file($_FILES["referral_image"]["tmp_name"], $path)){
                        $sql2 = "UPDATE app_control SET referral_image = '$path' WHERE app_control_id='1'";
                        $conn->query($sql2);
                        unlink($referrall_image);
                        // header('Location: control.php?msg=Controls updated!');
                    } 
                }
            }

            if($mt_deals_image){
                if(is_file($row['mt_deals_image'])){
                    $mt_dealss_image = $row['mt_deals_image'];
                }
                $type=pathinfo($_FILES['mt_deals_image']['name'],PATHINFO_EXTENSION);

                $randomid = mt_rand(100,999989);
                $path="Images/Category/$randomid.$type";
                $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG');
                if(in_array($type, $allowTypes)){
                    if(move_uploaded_file($_FILES["mt_deals_image"]["tmp_name"], $path)){
                        $sql2 = "UPDATE app_control SET mt_deals_image = '$path' WHERE app_control_id='1'";
                        $conn->query($sql2);
                        unlink($mt_dealss_image);
                        // header('Location: control.php?msg=Controls updated!');
                    } 
                }
            }


            if($mt_deals_icon){
                if(is_file($row['mt_deals_icon'])){
                    $mt_dealss_icon = $row['mt_deals_icon'];
                }
                $type=pathinfo($_FILES['mt_deals_icon']['name'],PATHINFO_EXTENSION);

                $randomid = mt_rand(100,999989);
                $path="Images/Category/$randomid.$type";
                $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG');
                if(in_array($type, $allowTypes)){
                    if(move_uploaded_file($_FILES["mt_deals_icon"]["tmp_name"], $path)){
                        $sql2 = "UPDATE app_control SET mt_deals_icon = '$path' WHERE app_control_id='1'";
                        $conn->query($sql2);
                        unlink($mt_dealss_icon);
                        // header('Location: control.php?msg=Controls updated!');
                    } 
                }
            }

            if($loginscreen_image){
                if(is_file($row['loginscreen_image'])){
                    $loginscreeny_image = $row['loginscreen_image'];
                }
                $type=pathinfo($_FILES['loginscreen_image']['name'],PATHINFO_EXTENSION);
                $randomid = mt_rand(100,99999);
                $path="Images/Category/$randomid.$type";
                $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG','gif','GIF');

                if(in_array($type, $allowTypes)){
                    if(move_uploaded_file($_FILES["loginscreen_image"]["tmp_name"], $path)){
                        $sql2 = "UPDATE app_control SET loginscreen_image = '$path' WHERE app_control_id='1'";
                        $conn->query($sql2);
                        unlink($loginscreeny_image);
                        // header('Location: control.php?msg=Controls updated!');
                    } 
                }
            }

            if($splash_image){
                if(is_file($row['splash_image'])){
                    $splashY_banner = $row['splash_image'];
                }
                $type=pathinfo($_FILES['splash_image']['name'],PATHINFO_EXTENSION);
                $randomid = mt_rand(100,99999);
                $path="Images/Category/$randomid.$type";
                $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG','gif','GIF');
                if(in_array($type, $allowTypes)){
                    if(move_uploaded_file($_FILES["splash_image"]["tmp_name"], $path)){
                        $sql2 = "UPDATE app_control SET splash_image = '$path' WHERE app_control_id='1'";
                        $conn->query($sql2);
                        unlink($splashY_banner);
                        // header('Location: control.php?msg=Controls updated!');
                    } 
                }
            }
            header('Location: control.php?msg=Controls updated!');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>App Controls | Salvo Ambulance</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <link href="assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/elements/avatar.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
    <link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />

</head>
<body class="sidebar-noneoverflow">

    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>

    <?php include('include/header.php') ?>

    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <?php include('include/sidebar.php') ?>

        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="row layout-top-spacing">
                    <?php include('include/notification.php') ?>
                    <div class="col-sm-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h4>App Controls</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form method="post" enctype="multipart/form-data">
                                    <?php
                                        $sql = "SELECT * FROM app_control WHERE app_control_id='1'";
                                        $result = $conn->query($sql);
                                        $row = $result->fetch_assoc();

                                        if($row['self_pickup_status'] == 1){
                                            $selfPickupStatus = 'checked';
                                        }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-4 mt-2">
                                            <label>Minimum Ordering Amount (₹)</label>
                                            <input type="number" min='0' name="minimum_order" id="minimum_order" class="form-control" placeholder="Minimum Ordering Amount" value="<?php echo $row['minimum_order'] ?>">
                                        </div>
                                        <div class="col-sm-4 mt-2">
                                            <label>Maximum Ordering Distance (KM)</label>
                                            <input type="number" min='0' name="order_distance" id="order_distance" class="form-control" placeholder="Maximum Ordering Distance" value="<?php echo $row['order_distance'] ?>">
                                        </div>
                                        <div class="col-sm-4 mt-2">
                                            <label>Minimum count for best selling product</label>
                                            <input type="number" min='0' name="best_selling_count" id="best_selling_count" class="form-control" placeholder="Minimum count for best selling product" value="<?php echo $row['best_selling_count'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-4">
                                            <label>Maximum count for cart</label>
                                            <input type="number" min='0' name="cart_count" id="cart_count" class="form-control" placeholder="Maximum count for cart" value="<?php echo $row['cart_count'] ?>">
                                        </div>
                                        <div class="col-sm-4 ">
                                            <label>Delivery Charge Amount (₹)</label>
                                            <input type="number" min='0' name="delivery_charge" id="delivery_charge" class="form-control" placeholder="Delivery Charge Amount" value="<?php echo $row['delivery_charge'] ?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Delivery Charge Upto (KM)</label>
                                            <input type="number" min='0' name="upto_distance" id="upto_distance" class="form-control" placeholder="Delivery Charge Upto" value="<?php echo $row['upto_distance'] ?>">
                                        </div>

                                        <!-- <div class="col-sm-4 mt-2">
                                            <label>App Opening Time</label>
                                            <input type="time" name="app_intime" id="app_intime" class="form-control" placeholder="App Opening Time" value="<?php echo $row['app_intime'] ?>">
                                        </div>
                                        <div class="col-sm-4 mt-2">
                                            <label>App Closing Time</label>
                                            <input type="time" name="app_outtime" id="app_outtime" class="form-control" placeholder="App Closing Time" value="<?php echo $row['app_outtime'] ?>">
                                        </div> -->
                                    </div>
                                    <div class="row mt-2">
                                       
                                        <div class="col-sm-4 ">
                                            <label>Increment Amount Per KM (₹)</label>
                                            <input type="number" min='0' name="increment" id="increment" class="form-control" placeholder="Increment Amount Per KM" value="<?php echo $row['increment'] ?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Referral Parent Amount</label>
                                            <input type="number" min="0" name="referral_parent_payment" placeholder="Referral Parent Amount" class="form-control" value="<?php echo $row['referral_parent_payment'] ?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Referral Child Amount</label>
                                            <input type="number" min="0" name="referral_child_payment" placeholder="Referral Child Amount" class="form-control" value="<?php echo $row['referral_child_payment'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-3">
                                            <label>Minimum Convertible Points</label>
                                            <input type="number" min='0' name="minimum_convertible_points" id="minimum_convertible_points" class="form-control" placeholder="Minimum Convertible Points" value="<?php echo $row['minimum_convertible_points'] ?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Minimum Purchase Amount For RP</label>
                                            <input type="number" min="0" name="minimum_purchase_amount" placeholder="Minimum Purchase Amount For RP" class="form-control" value="<?php echo $row['minimum_purchase_amount'] ?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Deliver Reward Points</label>
                                            <input type="number" min="0" name="minimum_purchase_points" placeholder="Minimum Purchase Points (Reward Points)" class="form-control" value="<?php echo $row['minimum_purchase_points'] ?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Minimum Points (Ex: Given Points = 1 Rs)</label>
                                            <input type="number" min="0" name="minimum_points" placeholder="Minimum Points (Ex: Given Points = 1 Rs)" class="form-control" value="<?php echo $row['minimum_points'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-4 ">
                                            <label>OTP Message</label>
                                            <input type="text" name="otp_message" id="otp_message" class="form-control" placeholder="OTP Messsage" value="<?php echo $row['otp_message'] ?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Instant Delivery Time</label>
                                            <input type="number" min="0" name="instant_delivery" placeholder="Instant Delivery Time" class="form-control" value="<?php echo $row['instant_service_time'] ?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Instagram</label>
                                            <input type="text" name="instagram_url" id="instagram_url" class="form-control" placeholder="Instagram" value="<?php echo $row['instagram_url'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-4">
                                            <label>Facebook</label>
                                            <input type="text" name="facebook_url" id="facebook_url" class="form-control" placeholder="Facebook" value="<?php echo $row['facebook_url'] ?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Youtube</label>
                                            <input type="text" name="youtube_url" id="youtube_url" class="form-control" placeholder="Youtube" value="<?php echo $row['youtube_url'] ?>">
                                        </div>

                                        <div class="col-sm-4">
                                            <label>Linkedin</label>
                                            <input type="text" name="linkedin_url" id="linkedin_url" class="form-control" placeholder="Linkedin" value="<?php echo $row['linkedin_url'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-6">
                                            <label>Service Not Available Content</label>
                                            <input type="text" name="service_not_available_content" id="service_not_available_content" class="form-control" placeholder="Service Not Available Content" value="<?php echo $row['service_not_available_content'] ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Instant Order Closing Time</label>
                                            <input type="time" name="instant_order_closing_time" id="instant_order_closing_time" class="form-control" placeholder="Instant Order Closing Time" value="<?php echo $row['instant_order_closing_time'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-5">
                                            <label>Splash Banner(400 * 400)</label>
                                            <small style="color:red;font-weight:700">[GIF image]</small>
										        <input type="file" name="splash_image" id="splash_image" class="form-control" >
                                        </div>
                                        <div class="col-sm-1 mt-4">
                                            <a href="<?php echo $row["splash_image"] ?>" target="_blank">
                                                <img style="width: 40px;height:40px" src="<?php echo $row["splash_image"] ?>" >
                                            </a>
                                        </div>
                                        <div class="col-sm-5">
                                            <label>Login Screen Image (720 * 1560)</label>  <small style="color:red;font-weight:700">[GIF image]</small>
										        <input type="file" name="loginscreen_image" id="loginscreen_image" class="form-control" >
                                        </div>
                                        <div class="col-sm-1 mt-4">
                                            <a href="<?php echo $row["loginscreen_image"] ?>" target="_blank">
                                                <img style="width: 40px;height:40px" src="<?php echo $row["loginscreen_image"] ?>">
                                            </a>
                                        </div>
                                        
                                    </div>

                                    <div class="row mt-2">
                                    <div class="col-sm-5">
                                            <label>Wallet Image (1200 * 438)</label>
										        <input type="file" name="wallet_banner" id="wallet_banner" class="form-control" >
                                        </div>
                                        <div class="col-sm-1 mt-4">
                                            <a href="<?php echo $row["wallet_banner"] ?>" target="_blank">
                                                <img style="width: 40px;height:40px" src="<?php echo $row["wallet_banner"] ?>">
                                            </a>
                                        </div>
                                        <div class="col-sm-5">
                                            <label>Referral Image (672 * 464)</label>
										        <input type="file" name="referral_image" id="referral_image" class="form-control" >
                                        </div>
                                        <div class="col-sm-1 mt-4">
                                            <a href="<?php echo $row["referral_image"] ?>" target="_blank">
                                                <img style="width: 40px;height:40px" src="<?php echo $row["referral_image"] ?>">
                                            </a>
                                        </div>
                                        
                                    </div>
                                   
                                    

                                    <div class="row mt-2">
                                        <div class="col-sm-5">
                                            <label>Membership Image(733 * 201)</label>
										        <input type="file" name="membership_image" id="membership_image" class="form-control" >
                                        </div>
                                        <div class="col-sm-1 mt-4">
                                            <a href="<?php echo $row["membership_image"] ?>" target="_blank">
                                                <img style="width: 40px;height:40px" src="<?php echo $row["membership_image"] ?>" >
                                            </a>
                                        </div>
                                        <div class="col-sm-5">
                                            <label>MT Way Image (672 * 464)</label>
										        <input type="file" name="mt_way_image" id="mt_way_image" class="form-control" >
                                        </div>
                                        <div class="col-sm-1 mt-4">
                                            <a href="<?php echo $row["mt_way_image"] ?>" target="_blank">
                                                <img style="width: 40px;height:40px" src="<?php echo $row["mt_way_image"] ?>">
                                            </a>
                                        </div>
                                    </div>
                                   


                                    <div class="row mt-2">
                                            <div class="col-sm-5">
                                                <label>MT Deals Image (512*512)</label>
                                                    <input type="file" name="mt_deals_image" id="mt_deals_image" class="form-control" >
                                            </div>
                                            <div class="col-sm-1 mt-4">
                                                <a href="<?php echo $row["mt_deals_image"] ?>" target="_blank">
                                                    <img style="width: 40px;height:40px" src="<?php echo $row["mt_deals_image"] ?>">
                                                </a>
                                            </div>
                                        
                                            <div class="col-sm-5">
                                            <label>MT Deals Icon (177 * 176)</label>
										        <input type="file" name="mt_deals_icon" id="mt_deals_icon" class="form-control" >
                                            </div>
                                            <div class="col-sm-1 mt-4">
                                                <a href="<?php echo $row["mt_deals_icon"] ?>" target="_blank">
                                                    <img style="width: 40px;height:40px" src="<?php echo $row["mt_deals_icon"] ?>">
                                                </a>
                                        </div>

                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-10">
                                            <label>UPI QR CODE (512 * 512 )</label>
										        <input type="file" name="upi_qr_code" id="upi_qr_code" class="form-control" >
                                        </div>
                                        <div class="col-sm-2 mt-4">
                                            <a href="<?php echo $row["upi_qr_code"] ?>" target="_blank">
                                                <img style="width: 40px;height:40px" src="<?php echo $row["upi_qr_code"] ?>">
                                            </a>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                        <div class="col-sm-4 mt-2">
                                            <label>Self Pickup</label><br>
                                            <label class="switch s-icons s-outline s-outline-success mr-2" style="margin-bottom: 0px !important">
                                                <input type="checkbox" id="S<?php echo $row['app_control_id'] ?>" <?php echo $selfPickupStatus ?> onclick="return selfPickupStatus(<?php echo $row['app_control_id'] ?>)">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div> -->
                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <input type="submit" name="add" onclick="return updateControl()" value="Update" class="float-right btn btn-primary mr-4 mt-4">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                include('include/footer.php')
            ?>
        </div>
    </div>

    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/manual.js"></script>
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>
</body>
</html>