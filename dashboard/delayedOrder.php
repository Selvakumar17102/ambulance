<?php
    ini_set('display_errors','on');
    include('include/connection.php');
    date_default_timezone_set("Asia/Calcutta");

    $instantOrder = 'active';
    $instantOrderShow = 'show';
    $instantOrderBoolean = 'true';
    $delayedOrder = 'active';

    $currentTime = date('H:s:i'); 
    $currentDate = date('Y-m-d'); 


    $start = $end = '';
    if($_REQUEST['fd'] != ''){
        $start = $_REQUEST['fd'];
        $end = $_REQUEST['ld'];
    } else{
        $end = date('Y-m-d');
        // $start = date('Y-m-d', strtotime($end.' - 6days'));
        $start = date('Y-m-d');

    }
    
    if(isset($_POST['refund'])){
        $id = $_REQUEST['order_id'];

        $sql = "SELECT * FROM orders WHERE order_id='$id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
            $order_string = $row['order_string'];
            $payment_amount = $row['payment_amount'];

            $message = 'Delayed Order Refund- Amount Refunded from Dashboard '.$order_string;

            $type=1;
                echo$sql1 = "INSERT INTO wallet_history (user_id,amount,date,time,order_id,type,message) VALUES ('$user_id','$payment_amount','$currentDate','$currentTime','$id','$type','$message')";
                if($conn->query($sql1) === TRUE){
                    $sql = "UPDATE user SET wallet=wallet+'$payment_amount' WHERE user_id='$user_id'";
                    $conn->query($sql);

                    $sql = "UPDATE orders SET is_refunded='1' WHERE order_id='$id'";
                    $conn->query($sql);

                    header('Location: delayedOrder.php?msg=Refunded!');
                }else{
                    header('Location: delayedOrder.php?msg=Not Refunded!');
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
        <title>Delayed Orders | Salvo Ambulance</title>

        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
        <link href="assets/css/loader.css" rel="stylesheet" type="text/css" />
        <script src="assets/js/loader.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />

        <link href="assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/elements/avatar.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css">
        <link href="assets/css/tables/table-basic.css" rel="stylesheet" type="text/css" />
        <link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
        <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
        <link href="plugins/tagInput/tags-input.css" rel="stylesheet" type="text/css" />

        <style>
            .tags-input-wrapper input { margin: 0 auto; }
        </style>
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
                    <div class="col-sm-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <h4>Filter</h4>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="row">
                                    <div class="col-sm-6 mt-2">
                                        <label for="fd">Start Date</label>
                                        <input type="date" id="fd" value="<?php echo $start ?>" class="form-control">
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <label for="ld">End Date</label>
                                        <input type="date" id="ld" value="<?php echo $end ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-12">
                                        <button class="btn btn-primary float-right" onclick="filterReport('delayedOrder.php')">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row layout-top-spacing">
                        <?php include('include/notification.php') ?>
                        <div id="tabsWithIcons" class="col-lg-12 col-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Delayed Orders</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area animated-underline-content">
                                    <div class="table-responsive">
                                        <table class="table mb-4 convert-data-table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Order Id</th>
                                                    <th class="text-center">Booking Date</th>
                                                    <th class="text-center">Booking Time</th>
                                                    <th class="text-center">Delivery Partner Arrived Time</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Address</th>
                                                    <th class="text-center">Payment Mode</th>
                                                    <th class="text-center">Total Amount</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Pay To Wallet</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    if($start && $end){
                                                        if($control == 0){
                                                            $sql = "SELECT * FROM orders WHERE (booking_date BETWEEN '$start' AND '$end') AND service_type='2' AND payment_type='Razorpay' AND delivery_partner_arrived_notification='1' ORDER BY order_id DESC";
                                                        }else{
                                                            $sql = "SELECT * FROM orders WHERE (booking_date BETWEEN '$start' AND '$end') AND login_id='$login_id' AND service_type='2' AND payment_type='Razorpay' AND delivery_partner_arrived_notification='1' ORDER BY order_id DESC";
                                                        }
                                                    }else{
                                                        if($control == 0){
                                                            $sql = "SELECT * FROM orders WHERE service_type='2' AND payment_type='Razorpay' AND delivery_partner_arrived_notification='1' ORDER BY order_id DESC";
                                                        }else{
                                                            $sql = "SELECT * FROM orders WHERE service_type='2' AND login_id='$login_id' AND payment_type='Razorpay' AND delivery_partner_arrived_notification='1' ORDER BY order_id DESC";
                                                        }
                                                    }
                                                    
                                                    $result = $conn->query($sql);
                                                    if($result->num_rows > 0){
                                                        $i = 1;
                                                        while($row = $result->fetch_assoc()){
                                                            $user_id = $row['user_id'];
                                                            $is_refunded = $row['is_refunded'];
                                                            $status = '';
                                                            
                                                            $booking_time = $row['booking_time'];
                                                            $delivery_partner_arrived_time = $row['delivery_partner_arrived_time'];

                                                            $et_time = date('H:i', strtotime($booking_time) + (60*60));
                                                            $et_time1 = date('H:i', strtotime($delivery_partner_arrived_time) + (60*60));
                                                            
                                                            $time    = explode(':',$et_time);
                                                            $minutes = ($time[0] * 60.0 + $time[1] * 1.0);																		
                                                            $total_mit = $minutes;
                                                            
                                                            $time1    = explode(':',$et_time1);
                                                            $minutes1 = ($time1[0] * 60.0 + $time1[1] * 1.0);																		
                                                            $total_mit1 = $minutes1;
                                                            
                                                            if($total_mit > $total_mit1){
                                                            //     $breach_status = "Late";
                                                            // }else{
                                                            //     // continue;
                                                            //     $breach_status = "Ontime";
                                                            // }

                                                            switch ($row['order_status']) {
                                                                case 0:
                                                                    $status = '<span class="badge outline-badge-danger">Cancelled</span>';
                                                                    break;
                                                                case 1:
                                                                    $status = '<span class="badge outline-badge-primary">Placed</span>';
                                                                    break;
                                                                case 2:
                                                                    $status = '<span class="badge outline-badge-primary">Processing</span>';
                                                                    break;
                                                                case 3:
                                                                    $status = '<span class="badge outline-badge-primary">Ready</span>';
                                                                    break;
                                                                case 4:
                                                                    $status = '<span class="badge outline-badge-primary">Picked Up</span>';
                                                                    break;
                                                                case 5:
                                                                    $status = '<span class="badge outline-badge-success">Delivered</span>';
                                                                    break;
                                                                
                                                                default:
                                                                    $status = '<span class="badge outline-badge-danger">Pending</span>';
                                                                    break;
                                                            }

                                                            $sql1 = "SELECT * FROM user WHERE user_id='$user_id'";
                                                            $result1 = $conn->query($sql1);
                                                            $row1 = $result1->fetch_assoc();
                                                ?>
                                                            <tr>
                                                                <td class="text-center"><?php echo $i++ ?></td>
                                                                <td class="text-center"><a href="view-order1.php?id=<?php echo $row['order_id'] ?>"><?php echo $row['order_string'] ?></a></td>
                                                                <td class="text-center"><?php echo date('d-m-Y', strtotime($row['booking_date'])) ?></td>
                                                                <td class="text-center"><?php echo date('h:i A', strtotime($row['booking_time'])) ?></td>
                                                                <td class="text-center"><?php echo date('h:i A', strtotime($delivery_partner_arrived_time)) ?></td>
                                                                <td class="text-center"><?php echo $row1['user_name'] ?></td>
                                                                <td class="text-center"><?php echo $row['user_address'] ?></td>
                                                                <td class="text-center"><?php echo $row['payment_type'] ?></td>
                                                                <td class="text-center">₹ <?php echo $row['total_amount'] ?></td>
                                                                <td class="text-center"><?php echo $status ?></td>
                                                                <td class="text-center">
                                                                    <?php if ($is_refunded==1){ ?>
                                                                        <span style="font-weight: 900">Order Refunded.</span>
                                                                    <?php }else{ ?>
                                                                        <form method="post">
                                                                            <input type="hidden" name="order_id" value="<?php echo $row["order_id"] ?>">
                                                                            <button type="submit" class="btn btn-success p-2" name="refund">
                                                                                <span style="font-weight: 900">Refund</span>
                                                                            </button>
                                                                        </form>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                <?php
                                                            }
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
        <script src="plugins/notification/snackbar/snackbar.min.js"></script>
    </body>
</html>