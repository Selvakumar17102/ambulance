<?php
    ini_set('display_errors','off');
    include('include/connection.php');
    include("../api/onesignaldelivery.php");
    include("../api/onesignaluser.php");
    include('../api/fcm.php');
    date_default_timezone_set("Asia/Kolkata");

    $date = date('Y-m-d');
	$time = date('H:i:s');

    $order = 'active';
    $orderShow = 'show';
    $orderBoolean = 'true';
    $newOrder = 'active';

    if(isset($_POST['delete'])){
        $id = $_REQUEST['order_id'];
        $cancelled_from = $_REQUEST['cancelled_from'];

        $sql = "SELECT * FROM orders WHERE order_id='$id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();

            $user_id = $row['user_id'];
            $wallet_amount = $row['wallet_amount'];
            $payment_amount = $row['payment_amount'];
            $order_string = $row['order_string'];

            if($row['payment_type'] == "Cash On Hand"){
                if($wallet_amount){
                    $sql = "UPDATE user SET wallet=wallet + $wallet_amount WHERE user_id='$user_id'";
                    $conn->query($sql);
    
                    $message = 'Amount Refund for'.$order_string;
                    $sql = "INSERT INTO wallet_history (user_id,amount,date,time,type,message,order_id) VALUES ('$user_id','$wallet_amount','$date','$time',1,'$message','$id')";
                    $conn->query($sql);
                }
            }

            if($row['payment_type'] == "Razorpay"){
                $sql = "UPDATE user SET wallet=wallet + $payment_amount WHERE user_id='$user_id'";
                $conn->query($sql);

                if($wallet_amount){
                    $sql = "UPDATE user SET wallet=wallet + $wallet_amount WHERE user_id='$user_id'";
                    $conn->query($sql);
                }

                $totalRefundAmount = $wallet_amount + $payment_amount;

                $message = 'Amount refund for'.$order_string;
                $sql = "INSERT INTO wallet_history (user_id,amount,date,time,type,message,order_id) VALUES ('$user_id','$totalRefundAmount','$date','$time',1,'$message','$id')";
                $conn->query($sql);
            }

            $sql = "SELECT * FROM user WHERE user_id='$user_id'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $user_name = $row['user_name'];
            $user_fcm_token = $row['user_fcm_token'];

            $title = 'Hi '.$user_name;
            $res = sendNotificationUser($user_id,$title,'Your order has been cancelled!','',$id, '0');

            $sql = "UPDATE orders SET order_status='0',cancelled_by='Cancelld By $name',cancelled_from='$cancelled_from' WHERE order_id='$id'";
            if($conn->query($sql) === TRUE){
                header('Location: newOrder.php?msg=Trip cancelled!');
            }
        }
    }
    if(isset($_POST['ready'])){
        $id = $_REQUEST['order_id'];

        $sql = "SELECT * FROM orders WHERE order_id='$id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
            $delivery_partner_id = $row['delivery_partner_id'];

            $sql = "SELECT * FROM user WHERE user_id='$user_id'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $user_name = $row['user_name'];
            $user_fcm_token = $row['user_fcm_token'];

            $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            $delivery_partner_name = $row['delivery_partner_name'];
            $delivery_partner_fcm = $row['delivery_partner_fcm'];

            $title = 'Hi '.$delivery_partner_name; 
            $res = sendNotificationDelivery($delivery_partner_id,$title, 'Your order is ready to be picked up','',$id, "3",'');

            $sql = "UPDATE orders SET order_status='3' WHERE order_id='$id'";
            if($conn->query($sql) === TRUE){
                header('Location: newOrder.php?msg=Trip ready!');
            } else{
                header('Location: newOrder.php?msg=No Trip ready!');
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Active Trips | Salvo Ambulance</title>
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
    <link href="assets/css/tables/table-basic.css" rel="stylesheet" type="text/css" />
    <link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
    <link href="assets/css/components/tabs-accordian/custom-tabs.css" rel="stylesheet" type="text/css" />

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
                    <div id="tabsWithIcons" class="col-lg-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Active Trips</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area animated-underline-content">
                                <ul class="nav nav-tabs  mb-3" id="animateLine" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="arrived-tab" data-toggle="tab" href="#arrived" role="tab" aria-controls="arrived" aria-selected="true">
                                            <img style="width: 25px" src="assets/img/icon/arrived.png" alt="">
                                            <span class="ml-1">Booked</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="processing-tab" data-toggle="tab" href="#processing" role="tab" aria-controls="processing" aria-selected="false">
                                            <img style="width: 25px" src="assets/img/icon/processing.png" alt="">
                                            <span class="ml-1">Aceepted</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="ready-tab" data-toggle="tab" href="#ready" role="tab" aria-controls="ready" aria-selected="false">
                                            <img style="width: 25px" src="assets/img/icon/ready.png" alt="">
                                            <span class="ml-1">On The Way</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pickup-tab" data-toggle="tab" href="#pickup" role="tab" aria-controls="pickup" aria-selected="false">
                                            <img style="width: 25px" src="assets/img/icon/pickedup.png" alt="">
                                            <span class="ml-1">Picked Up</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="animateLineContent-4">
                                    <div class="tab-pane fade show active" id="arrived" role="tabpanel" aria-labelledby="arrived-tab">
                                        <div class="table-responsive">
                                            <table class="table mb-4 convert-data-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Trip Id</th>
                                                        <th class="text-center">Booking Date/Time</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Pickup Address</th>
                                                        <th class="text-center">Drop Address</th>
                                                        <th class="text-center">Payment Mode</th>
                                                        <th class="text-center">Driver</th>
                                                        <th class="text-center">Total Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="arrivedTablebody">
                                                    <?php
                                                        if($control == 0){
                                                            $sql = "SELECT * FROM orders WHERE order_status='1' AND order_type='0' AND service_type='1' ORDER BY order_id DESC";
                                                        }else{
                                                            $sql = "SELECT * FROM orders WHERE order_status='1' AND order_type='0' AND login_id='$login_id' AND service_type='1' ORDER BY order_id DESC";
                                                        }
                                                        $result = $conn->query($sql);
                                                        if($result->num_rows > 0){
                                                            $i = 1;
                                                            while($row = $result->fetch_assoc()){
                                                                $user_id = $row['user_id'];
                                                                $delivery_partner_id = $row['delivery_partner_id'];

                                                                $sql1 = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
                                                                $result1 = $conn->query($sql1);
                                                                $row1 = $result1->fetch_assoc();

                                                                $delivery_partner_name = $row1['delivery_partner_name'];

                                                                $sql1 = "SELECT * FROM user WHERE user_id='$user_id'";
                                                                $result1 = $conn->query($sql1);
                                                                $row1 = $result1->fetch_assoc();

                                                                $booking_date = date('d-m-Y', strtotime($row['booking_date']));
                                                                $booking_time = date('h:i A', strtotime($row['booking_time']));

                                                                $delivery_date = date('d-m-Y', strtotime($row['delivery_date']));
                                                                $time_slot=$row['slot'];


                                                                $bookings = $booking_date.'<br>'.$booking_time;
                                                                $deliverys = $delivery_date.'<br>'.$time_slot;

                                                    ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo $i++ ?></td>
                                                                    <td class="text-center"><a href="view-order.php?id=<?php echo $row['order_id'] ?>"><?php echo $row['order_string'] ?></a></td>
                                                                    <td class="text-center"><?php echo $bookings ?></td>
                                                                    <td class="text-center"><?php echo $row1['user_name'] ?></td>
                                                                    <td class="text-center"><?php echo $row['pickup_address'] ?></td>
                                                                    <td class="text-center"><?php echo $row['drop_address'] ?></td>
                                                                    <td class="text-center"><?php echo $row['payment_type'] ?></td>
                                                                    <td class="text-center"><?php echo ucfirst($delivery_partner_name) ?></td>
                                                                    <td class="text-center">₹ <?php echo $row['total_amount'] ?></td>
                                                                </tr>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="processing" role="tabpanel" aria-labelledby="processing-tab">
                                        <div class="table-responsive">
                                            <table class="table mb-4 convert-data-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Trip Id</th>
                                                        <th class="text-center">Booking Date/Time</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Pickup Address</th>
                                                        <th class="text-center">Drop Address</th>
                                                        <th class="text-center">Payment Mode</th>
                                                        <th class="text-center">Driver</th>
                                                        <th class="text-center">Total Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="processingTablebody">
                                                    <?php
                                                        if($control == 0){
                                                            $sql = "SELECT * FROM orders WHERE order_status='2' AND order_type='0' AND service_type='1' ORDER BY order_id DESC";
                                                        } else{
                                                            $sql = "SELECT * FROM orders WHERE order_status='2' AND order_type='0' AND login_id='$login_id' AND service_type='1' ORDER BY order_id DESC";
                                                        }
                                                        $result = $conn->query($sql);
                                                        if($result->num_rows > 0){
                                                            $i = 1;
                                                            while($row = $result->fetch_assoc()){
                                                                $user_id = $row['user_id'];
                                                                $delivery_partner_id = $row['delivery_partner_id'];

                                                                $sql1 = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
                                                                $result1 = $conn->query($sql1);
                                                                $row1 = $result1->fetch_assoc();

                                                                $delivery_partner_name = $row1['delivery_partner_name'];

                                                                $sql1 = "SELECT * FROM user WHERE user_id='$user_id'";
                                                                $result1 = $conn->query($sql1);
                                                                $row1 = $result1->fetch_assoc();

                                                                $booking_date = date('d-m-Y', strtotime($row['booking_date']));
                                                                $booking_time = date('h:i A', strtotime($row['booking_time']));
                                                    
                                                                $delivery_date = date('d-m-Y', strtotime($row['delivery_date']));
                                                                $time_slot=$row['slot'];
                                                    
                                                                $bookings = $booking_date.'<br>'.$booking_time;
                                                                $deliverys = $delivery_date.'<br>'.$time_slot;
                                                    ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo $i++ ?></td>
                                                                    <td class="text-center"><a href="view-order.php?id=<?php echo $row['order_id'] ?>"><?php echo $row['order_string'] ?></a></td>
                                                                    <td class="text-center"><?php echo $bookings ?></td>
                                                                    <td class="text-center"><?php echo $row1['user_name'] ?></td>
                                                                    <td class="text-center"><?php echo $row['pickup_address'] ?></td>
                                                                    <td class="text-center"><?php echo $row['drop_address'] ?></td>
                                                                    <td class="text-center"><?php echo $row['payment_type'] ?></td>
                                                                    <td class="text-center"><?php echo ucfirst($delivery_partner_name) ?></td>
                                                                    <td class="text-center">₹ <?php echo $row['total_amount'] ?></td>
                                                                </tr>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="ready" role="tabpanel" aria-labelledby="ready-tab">
                                        <div class="table-responsive">
                                            <table class="table mb-4 convert-data-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Trip Id</th>
                                                        <th class="text-center">Booking Date/Time</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Pickup Address</th>
                                                        <th class="text-center">Drop Address</th>
                                                        <th class="text-center">Payment Mode</th>
                                                        <th class="text-center">Driver</th>
                                                        <th class="text-center">Total Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="readyTablebody">
                                                    <?php
                                                        if($control == 0){
                                                            $sql = "SELECT * FROM orders WHERE order_status='3' AND order_type='0' AND service_type='1' ORDER BY order_id DESC";
                                                        } else{
                                                            $sql = "SELECT * FROM orders WHERE order_status='3' AND order_type='0' AND login_id='$login_id' AND service_type='1' ORDER BY order_id DESC";
                                                        }
                                                        $result = $conn->query($sql);
                                                        if($result->num_rows > 0){
                                                            $i = 1;
                                                            while($row = $result->fetch_assoc()){
                                                                $user_id = $row['user_id'];
                                                                $delivery_partner_id = $row['delivery_partner_id'];

                                                                $sql1 = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
                                                                $result1 = $conn->query($sql1);
                                                                $row1 = $result1->fetch_assoc();

                                                                $delivery_partner_name = $row1['delivery_partner_name'];

                                                                $sql1 = "SELECT * FROM user WHERE user_id='$user_id'";
                                                                $result1 = $conn->query($sql1);
                                                                $row1 = $result1->fetch_assoc();

                                                                if($row['pickup_otp']==''){
                                                                    $pickup_otp = 'N/A';
                                                                }else{
                                                                    $pickup_otp = $row['pickup_otp'];
                                                                }
                                                                $booking_date = date('d-m-Y', strtotime($row['booking_date']));
                                                                $booking_time = date('h:i A', strtotime($row['booking_time']));
                                                    
                                                                $delivery_date = date('d-m-Y', strtotime($row['delivery_date']));
                                                                $time_slot=$row['slot'];
                                                    
                                                    
                                                                $bookings = $booking_date.'<br>'.$booking_time;
                                                                $deliverys = $delivery_date.'<br>'.$time_slot;
                                                    ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo $i++ ?></td>
                                                                    <td class="text-center"><a href="view-order.php?id=<?php echo $row['order_id'] ?>"><?php echo $row['order_string'] ?></a></td>
                                                                    <td class="text-center"><?php echo $bookings ?></td>
                                                                    <td class="text-center"><?php echo $row1['user_name'] ?></td>
                                                                    <td class="text-center"><?php echo $row['pickup_address'] ?></td>
                                                                    <td class="text-center"><?php echo $row['drop_address'] ?></td>
                                                                    <td class="text-center"><?php echo $row['payment_type'] ?></td>
                                                                    <td class="text-center"><?php echo ucfirst($delivery_partner_name) ?></td>
                                                                    <td class="text-center">₹ <?php echo $row['total_amount'] ?></td>
                                                                </tr>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pickup" role="tabpanel" aria-labelledby="pickup-tab">
                                        <div class="table-responsive">
                                            <table class="table mb-4 convert-data-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Trip Id</th>
                                                        <th class="text-center">Booking Date/Time</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Pickup Address</th>
                                                        <th class="text-center">Drop Address</th>
                                                        <th class="text-center">Payment Mode</th>
                                                        <th class="text-center">Driver</th>
                                                        <th class="text-center">Total Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="pickupTablebody">
                                                    <?php
                                                        if($control == 0){
                                                            $sql = "SELECT * FROM orders WHERE order_status='4' AND order_type='0' AND service_type='1' ORDER BY order_id DESC";
                                                        } else{
                                                            $sql = "SELECT * FROM orders WHERE order_status='4' AND order_type='0' AND login_id='$login_id' AND service_type='1' ORDER BY order_id DESC";
                                                        }
                                                        $result = $conn->query($sql);
                                                        if($result->num_rows > 0){
                                                            $i = 1;
                                                            while($row = $result->fetch_assoc()){
                                                                $user_id = $row['user_id'];
                                                                $delivery_partner_id = $row['delivery_partner_id'];

                                                                $sql1 = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
                                                                $result1 = $conn->query($sql1);
                                                                $row1 = $result1->fetch_assoc();

                                                                $delivery_partner_name = $row1['delivery_partner_name'];

                                                                $sql1 = "SELECT * FROM user WHERE user_id='$user_id'";
                                                                $result1 = $conn->query($sql1);
                                                                $row1 = $result1->fetch_assoc();

                                                                $booking_date = date('d-m-Y', strtotime($row['booking_date']));
                                                                $booking_time = date('h:i A', strtotime($row['booking_time']));
                                                    
                                                                $delivery_date = date('d-m-Y', strtotime($row['delivery_date']));
                                                                $time_slot=$row['slot'];
                                                    
                                                    
                                                                $bookings = $booking_date.'<br>'.$booking_time;
                                                                $deliverys = $delivery_date.'<br>'.$time_slot;
                                                    ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo $i++ ?></td>
                                                                    <td class="text-center"><a href="view-order.php?id=<?php echo $row['order_id'] ?>"><?php echo $row['order_string'] ?></a></td>
                                                                    <td class="text-center"><?php echo $bookings ?></td>
                                                                    <td class="text-center"><?php echo $row1['user_name'] ?></td>
                                                                    <td class="text-center"><?php echo $row['pickup_address'] ?></td>
                                                                    <td class="text-center"><?php echo $row['drop_address'] ?></td>
                                                                    <td class="text-center"><?php echo $row['payment_type'] ?></td>
                                                                    <td class="text-center"><?php echo ucfirst($delivery_partner_name) ?></td>
                                                                    <td class="text-center">₹ <?php echo $row['total_amount'] ?></td>
                                                                </tr>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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
    <script src="plugins/table/datatable/datatables.js"></script>
    <script src="assets/js/manual.js"></script>
    <script src="assets/js/order.js"></script>
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>
</body>
</html>