<?php
    ini_set('display_errors','off');
    include('include/connection.php');
    $dashboard = 'active';
    $dashboardBoolean = 'true';

    $total_req_sql = "SELECT * FROM blood_request";
    $total_req_result = $conn->query($total_req_sql);
    $total_blood_requests = $total_req_result->num_rows;

    $emergency_req_sql = "SELECT * FROM blood_request WHERE emergency_status = '1'";
    $emergency_req_result = $conn->query($emergency_req_sql);
    $emergency_req_count = $emergency_req_result->num_rows;

    $non_emergency_req_sql = "SELECT * FROM blood_request WHERE emergency_status = '0'";
    $non_emergency_req_result = $conn->query($non_emergency_req_sql);
    $non_emergency_req_count = $non_emergency_req_result->num_rows;

    $total_ambulance_req_sql = "SELECT * FROM orders";
    $total_ambulance_req_result = $conn->query($total_ambulance_req_sql);
    $total_ambulance_req = $total_ambulance_req_result->num_rows;

    $cancelled_ambulance_req_sql = "SELECT * FROM orders WHERE order_status = '0'";
    $cancelled_ambulance_req_result = $conn->query($cancelled_ambulance_req_sql);
    $cancelled_ambulance_req = $cancelled_ambulance_req_result->num_rows;

    // $accepted_ambulance_req_sql = "SELECT * FROM orders WHERE order_status = '2'";
    // $accepted_ambulance_req_result = $conn->query($accepted_ambulance_req_sql);
    // $accepted_ambulance_req = $accepted_ambulance_req_result->num_rows;

    $completed_ambulance_req_sql = "SELECT * FROM orders WHERE order_status = '7'";
    $completed_ambulance_req_result = $conn->query($completed_ambulance_req_sql);
    $completed_ambulance_req = $completed_ambulance_req_result->num_rows;
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Dashboard | Salvo Ambulance </title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
   
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <style>
        .flex-space-between{
            display: flex;
            justify-content: space-between;
        }
        .inner-flex{
            display: flex;
            justify-content: flex-end;
            margin-bottom: 0px;
            color: #880E4F;
            font-weight: 600;
        }
    </style>

</head>
<body class="sidebar-noneoverflow">
   
    <!--  BEGIN NAVBAR  -->
    <?php include('include/header.php') ?>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <?php include('include/sidebar.php') ?>
        <!--  END SIDEBAR  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <?php include('include/notification.php') ?>

                <div class="row layout-top-spacing">
                    <div class="widget widget-table-four col-sm-12">
                        <center>
                            <div class="widget-content ">
                                <div class="flex-space-between ">
                                    <h2 class="">Welcome to Salvo Ambulance Dashboard!!!!</h2>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>

                <div class="row layout-top-spacing">
                    <a href="#" class="col-sm-6">
                        <div class="widget widget-table-four">
                            <div class="widget-content">
                                <div class="flex-space-between">
                                    <div>
                                        <img style="width: 80px" src="assets/img/icon/dashboard/sale.png">
                                    </div>
                                    <div>
                                        <h4 class="inner-flex mb-2" style="color: #8BC34A"><?php echo $total_blood_requests; ?></h4>
                                        <h5 class="">Total Blood Requests</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="col-sm-6">
                        <div class="widget widget-table-four">
                            <div class="widget-content">
                                <div class="flex-space-between">
                                    <div>
                                        <img style="width: 80px" src="assets/img/icon/dashboard/sale.png">
                                    </div>
                                    <div>
                                        <h4 class="inner-flex mb-2" style="color: #8BC34A"><?php echo $emergency_req_count; ?></h4>
                                        <h5 class="">Emergency Blood Requests</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="row layout-top-spacing">
                    <a href="#" class="col-sm-6">
                        <div class="widget widget-table-four">
                            <div class="widget-content">
                                <div class="flex-space-between">
                                    <div>
                                        <img style="width: 80px" src="assets/img/icon/dashboard/sale.png">
                                    </div>
                                    <div>
                                        <h4 class="inner-flex mb-2" style="color: #8BC34A"><?php echo $non_emergency_req_count; ?></h4>
                                        <h5 class="">Non-Emergency Blood Requests</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="col-sm-6">
                        <div class="widget widget-table-four">
                            <div class="widget-content">
                                <div class="flex-space-between">
                                    <div>
                                        <img style="width: 80px" src="assets/img/icon/dashboard/sale.png">
                                    </div>
                                    <div>
                                        <h4 class="inner-flex mb-2" style="color: #8BC34A"><?php echo $total_ambulance_req; ?></h4>
                                        <h5 class="">Total Ambulance Requests</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="row layout-top-spacing">
                    <a href="#" class="col-sm-6">
                        <div class="widget widget-table-four">
                            <div class="widget-content">
                                <div class="flex-space-between">
                                    <div>
                                        <img style="width: 80px" src="assets/img/icon/dashboard/sale.png">
                                    </div>
                                    <div>
                                        <h4 class="inner-flex mb-2" style="color: #8BC34A"><?php echo $cancelled_ambulance_req; ?></h4>
                                        <h5 class="">Cancelled Ambulance Requests</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="col-sm-6">
                        <div class="widget widget-table-four">
                            <div class="widget-content">
                                <div class="flex-space-between">
                                    <div>
                                        <img style="width: 80px" src="assets/img/icon/dashboard/sale.png">
                                    </div>
                                    <div>
                                        <h4 class="inner-flex mb-2" style="color: #8BC34A"><?php echo $completed_ambulance_req; ?></h4>
                                        <h5 class="">Completed Ambulance Requests</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="row layout-top-spacing">
                    <?php include('include/notification.php') ?>
                    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-chart-one">
                            <div class="widget-heading">
                                <h5 class="">Requests</h5>
                                <ul class="tabs tab-pills">
                                    <li><a id="tb_1" class="tabmenu">This Year</a></li>
                                </ul>
                            </div>

                            <div class="widget-content">
                                <div class="tabs tab-content">
                                    <div id="content_1" class="tabcontent"> 
                                        <div id="requestMonthly"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-chart-two">
                            <div class="widget-heading">
                                <h5 class="">Request Details</h5>
                            </div>
                            <div class="widget-content">
                                <div id="requestDetails" class=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('include/footer.php') ?>
        </div>
        <!--  BEGIN CONTENT AREA  -->
       
          
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->

    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
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
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="plugins/apex/apexcharts.min.js"></script>
    <?php include('map.php'); ?>
    <script src="assets/js/dashboard/dash_2.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>
</html>

<script>
    // Your function to be executed
    function myFunction() {
        header('Location: city.php');
        // Place your function logic here
    }

    // Loop to run the function every second
    while (true) {
        myFunction();
        sleep(1); // Sleep for 1 second
    }
</script>