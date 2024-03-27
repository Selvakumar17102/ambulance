<?php
    ini_set('display_errors','off');
    include('include/connection.php');
    date_default_timezone_set('Asia/Kolkata');
    $todayDate = date('Y-m-d');

    $instantOrder = 'active';
    $instantOrderShow = 'show';
    $instantOrderBoolean = 'true';
    $newOrder1 = 'active';

    $id = $_REQUEST['id'];

    $sql = "SELECT * FROM orders WHERE order_id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $service_type = $row['service_type'];
    $delivery_partner_id = $row['delivery_partner_id'];

    $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
    $result = $conn->query($sql);
    $driverTable = $result->fetch_assoc();

    if($service_type == 1){
        $spanClass = "badge badge-danger";
    } else{
        $spanClass = "badge badge-primary";
    }

    $sql1 = "SELECT * FROM service_type WHERE service_type_id='$service_type'";
    $result1 = $conn->query($sql1);
    $serviceTypeTable = $result1->fetch_assoc();

    $status = '';

    switch ($row['order_status']) {
        case 0:
            $status = 'Cancelled';
            break;
        case 1:
            $status = 'Booked';
            break;
        case 2:
            $status = 'Aceepted';
            break;
        case 3:
            $status = 'On The Way';
            break;
        case 4:
            $status = 'Picked Up';
            break;
        case 5:
            $status = 'Drop';
            break;
        case 6:
            $status = 'Cash Collected';
            break;
        case 7:
            $status = 'Completed';
            break;
        default:
            $status = 'Pending';
            break;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>View Trip | Salvo Ambulance</title>
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
    <link href="plugins/tagInput/tags-input.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/pages/faq/faq2.css" rel="stylesheet" type="text/css" /> 

    <style>
        .tags-input-wrapper input { margin: 0 auto; }
        .border{
            border: 2px solid #9CECD6 !important;
            border-radius: 8px;
        }
        .smallBorder{
            height: 46px;
        }
        .largeBorder{
            height: 75px;
        }
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
                    <?php include('include/notification.php') ?>
                    <div class="faq p-1" style="width: 100%">

                        <div class="faq-layouting layout-spacing">

                            <div class="fq-tab-section layout-top-spacing">
                                <div class="row">
                                    <div class="col-md-12">

                                        <h2 style="margin-bottom: 10px">View Trip - <span><?php echo $row['order_string'] ?></span></h2>
                                        <p class="text-center" style="font-weight: 900">Total Amount: ₹ <?php echo $row['total_amount'] ?></p>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="accordion">
                                                    
                                                    <div class="card">
                                                        <div class="card-header" id="fqheadingSix6">
                                                            <div class="mb-0" aria-expanded="true">
                                                                <span class="faq-q-title">User Details</span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            $user_id = $row['user_id'];

                                                            $sql1 = "SELECT * FROM user WHERE user_id='$user_id'";
                                                            $result1 = $conn->query($sql1);
                                                            $row1 = $result1->fetch_assoc();
                                                            if($row1['membership_id']){
                                                                $expiry_date = $row1['expiry_date'];
                                                                if($expiry_date>=$todayDate){
                                                                    $memberShip = 'Yes';
                                                                }else{
                                                                    $memberShip = 'No';
                                                                }
                                                            }else{
                                                                $memberShip = 'No';
                                                            }
                                                            $booking_date = date('d-m-Y', strtotime($row['booking_date']));
                                                            $booking_time = date('h:i A', strtotime($row['booking_time']));
                                                
                                                            $delivery_date = date('d-m-Y', strtotime($row['booking_date']));
                                                            $time_slot = date('h:i A', strtotime($row['slot']));
                                                
                                                
                                                            $bookings = $booking_date.' / '.$booking_time;
                                                            $deliverys = $delivery_date.' / '.$time_slot;

                                                        ?>
                                                        <div class="collapse show" aria-labelledby="fqheadingSix6" data-parent="#simple_faq1">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-lg-4">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Name: <span style="color: #E91E63;font-weight: 900"><?php echo ucfirst($row1['user_name']) ?></span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Phone: <span style="color: #E91E63;font-weight: 900"><?php echo $row1['user_phone_number'] ?></span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Email: <span style="color: #E91E63;font-weight: 900"><?php echo $row1['user_email'] ?></span></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="row mt-3">
                                                                    <div class="col-lg-12">
                                                                        <div class="border pl-2 largeBorder">
                                                                            <label for="" class="col-form-label">Address: <span style="color: #E91E63;font-weight: 900"><?php echo $row['user_address'] ?></span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="border pl-2 largeBorder">
                                                                            <label for="" class="col-form-label">Landmark: <span style="color: #E91E63;font-weight: 900"><?php echo $row['user_landmark'] ?></span></label>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <div class="accordion">
                                                    <div class="card">
                                                        <div class="card-header" id="fqheadingSix6">
                                                            <div class="mb-0" aria-expanded="true">
                                                                <span class="faq-q-title">Trip Details</span>
                                                            </div>
                                                        </div>
                                                        <div class="collapse show" aria-labelledby="fqheadingSix6" data-parent="#simple_faq1">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-lg-4">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Driver: <span style="color: #E91E63;font-weight: 900"><?php echo $driverTable['delivery_partner_name'] ?></span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Trip Status: <span style="color: #E91E63;font-weight: 900"><?php echo $status ?></span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Payment Mode: <span style="color: #E91E63;font-weight: 900"><?php echo $row['payment_type'] ?></span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 mt-2">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Service Type: 
                                                                                <span class="<?php echo $spanClass ?>" style="font-weight: 900">
                                                                                    <?php echo $serviceTypeTable['service_type_name'] ?>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 mt-2">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Booking Date & Time: <span style="color: #E91E63;font-weight: 900"><?php echo $bookings ?></span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 mt-2">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Pickup Address: <span style="color: #E91E63;font-weight: 900"><?php echo $row['pickup_address'] ?></span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 mt-2">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Drop Address: <span style="color: #E91E63;font-weight: 900"><?php echo $row['drop_address'] ?></span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 mt-2">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Accepted Time: 
                                                                                <span style="color: #E91E63;font-weight: 900">
                                                                                    <?php
                                                                                        if($row['accept_time']){
                                                                                            echo date('h:i A', strtotime($row['accept_time']));
                                                                                        } else{
                                                                                            echo 'N/A';
                                                                                        }
                                                                                    ?>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 mt-2">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Start Time: 
                                                                                <span style="color: #E91E63;font-weight: 900">
                                                                                    <?php
                                                                                        if($row['trip_start_time']){
                                                                                            echo date('h:i A', strtotime($row['trip_start_time']));
                                                                                        } else{
                                                                                            echo 'N/A';
                                                                                        }
                                                                                    ?>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 mt-2">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Pickedup Time: 
                                                                                <span style="color: #E91E63;font-weight: 900">
                                                                                    <?php
                                                                                        if($row['pickup_time']){
                                                                                            echo date('h:i A', strtotime($row['pickup_time']));
                                                                                        } else{
                                                                                            echo 'N/A';
                                                                                        }
                                                                                    ?>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 mt-2">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Completed Time: 
                                                                                <span style="color: #E91E63;font-weight: 900">
                                                                                    <?php
                                                                                        if($row['trip_completed_time']){
                                                                                            echo date('h:i A', strtotime($row['trip_completed_time']));
                                                                                        } else{
                                                                                            echo 'N/A';
                                                                                        }
                                                                                    ?>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                        if($row['cancel_time']){
                                                                    ?>
                                                                            <div class="col-lg-4 mt-2">
                                                                                <div class="border pl-2 smallBorder">
                                                                                    <label for="" class="col-form-label">Cancel Time: 
                                                                                        <span style="color: #E91E63;font-weight: 900">
                                                                                            <?php
                                                                                                if($row['cancel_time']){
                                                                                                    echo date('h:i A', strtotime($row['cancel_time']));
                                                                                                } else{
                                                                                                    echo 'N/A';
                                                                                                }
                                                                                            ?>
                                                                                        </span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                    <div class="col-lg-4 mt-2">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Driver Earning: <span style="color: #E91E63;font-weight: 900">₹ <?php echo $row['total_amount'] - $row['amount_for_client'] ?></span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 mt-2">
                                                                        <div class="border pl-2 smallBorder">
                                                                            <label for="" class="col-form-label">Agent Earning: <span style="color: #E91E63;font-weight: 900">₹ <?php echo $row['amount_for_client'] ?></span></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    <script src="assets/js/manual.js"></script>
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>
</body>
</html>