<?php
    ini_set('display_errors','off');
    include('include/connection.php');

    $order = 'active';
    $orderShow = 'show';
    $orderBoolean = 'true';
    $pendingOrder = 'active';

    $start = $end = '';
    if($_REQUEST['fd'] != ''){
        $start = $_REQUEST['fd'];
        $end = $_REQUEST['ld'];
    } else{
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime($end.' - 6days'));
        // $start = date('Y-m-d');

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Pending Orders | Salvo Ambulance</title>
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
                                        <button class="btn btn-primary float-right" onclick="filterReport('pendingOrder.php')">Filter</button>
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
                                        <h4>Pending Orders</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area animated-underline-content">
                                <div class="table-responsive">
                                    <table class="table mb-4 convert-data-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Order Id</th>
                                                <th class="text-center">Booking Date/Time</th>
                                                    <th class="text-center">Delivery Date/Time</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Address</th>
                                                <th class="text-center">Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if($control == 0){
                                                    $sql = "SELECT * FROM orders WHERE (booking_date BETWEEN '$start' AND '$end') AND order_status=6 AND service_type='1' ORDER BY order_id DESC";
                                                } else{
                                                    $sql = "SELECT * FROM orders WHERE (booking_date BETWEEN '$start' AND '$end') AND login_id='$login_id' AND order_status=6 AND service_type='1' ORDER BY order_id DESC";
                                                }
                                                $result = $conn->query($sql);
                                                if($result->num_rows > 0){
                                                    $i = 1;
                                                    while($row = $result->fetch_assoc()){
                                                        $user_id = $row['user_id'];

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
                                                            <td class="text-center">
                                                                <ul class="table-controls">
                                                                    <li>
                                                                        <a onclick="return confirm('Sure to accept this order!')" href="accept-order.php?id=<?php echo $row['order_id'] ?>&page=newOrder" class="btn btn-success p-2">
                                                                            <span style="font-weight: 900">Accept</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a onclick="return confirm('Sure to cancel this order!')" href="cancel-order.php?id=<?php echo $row['order_id'] ?>&cancelled_from=Pre Order - Pending&page=pendingOrder" class="btn btn-danger p-2">
                                                                            <span style="font-weight: 900">Cancel</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                            <td class="text-center"><a href="view-order.php?id=<?php echo $row['order_id'] ?>"><?php echo $row['order_string'] ?></a></td>
                                                            <td class="text-center"><?php echo $bookings ?></td>
                                                            <td class="text-center"><?php echo $deliverys ?></td>
                                                            <td class="text-center"><?php echo $row1['user_name'] ?></td>
                                                            <td class="text-center"><?php echo $row['user_address'] ?></td>
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