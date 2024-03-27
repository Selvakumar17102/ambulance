<?php
    ini_set('display_errors','off');
    include('include/connection.php');
    $order = 'active';
    $orderShow = 'show';
    $orderBoolean = 'true';
    $deliveredOrder = 'active';

    $user_id = $_REQUEST['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Delivered Orders | Salvo Ambulance</title>
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
                    <?php include('include/notification.php') ?>
                    <div id="tabsWithIcons" class="col-lg-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Delivered Orders</h4>
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
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Address</th>
                                                <th class="text-center">Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql = "SELECT * FROM orders WHERE order_status='5' AND user_id='$user_id' ORDER BY order_id DESC";
                                                $result = $conn->query($sql);
                                                if($result->num_rows > 0){
                                                    $i = 1;
                                                    while($row = $result->fetch_assoc()){
                                                        $user_id = $row['user_id'];
                                                        
                                                        $sql1 = "SELECT * FROM user WHERE user_id='$user_id'";
                                                        $result1 = $conn->query($sql1);
                                                        $row1 = $result1->fetch_assoc();
                                            ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $i++ ?></td>
                                                            <td class="text-center"><a href="view-order.php?id=<?php echo $row['order_id'] ?>"><?php echo $row['order_string'] ?></a></td>
                                                            <td class="text-center"><?php echo date('d-m-Y', strtotime($row['booking_date'])) ?></td>
                                                            <td class="text-center"><?php echo date('h:i A', strtotime($row['booking_time'])) ?></td>
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