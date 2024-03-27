<?php
    ini_set('display_errors','off');
    include('include/connection.php');
    $dashboard = 'active';
    $dashboardBoolean = 'true';

    $totalSales = $totalOrders = $newOrders1 = $newOrders2 = $totalUsers = 0;
    if($control == 0){
        $sql = "SELECT * FROM orders";
    } else{
        $sql = "SELECT * FROM orders WHERE login_id='$login_id'";
    }
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        $totalOrders++;
        if($row['order_status'] == 1 && $row['service_type']==1){
            $newOrders1++;
        }else if($row['order_status'] == 1 && $row['service_type']==2){
            $newOrders2++;
        } else{
            if($row['order_status'] == 5){
                $totalSales += $row['total_amount'];
            }
        }
    }

    $totalUsers = $conn->query("SELECT * FROM user WHERE user_name!=''")->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Dashboard | Salvo Ambulance</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <link href="assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
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
                    <a href="sales-report.php" class="col-sm-4">
                        <div class="widget widget-table-four">
                            <div class="widget-content">
                                <div class="flex-space-between">
                                    <div>
                                        <img style="width: 80px" src="assets/img/icon/dashboard/sale.png">
                                    </div>
                                    <div>
                                        <h4 class="inner-flex mb-2" style="color: #8BC34A">₹ <?php echo number_format($totalSales) ?></h4>
                                        <h5 class="">Total Sales</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="allOrder.php" class="col-sm-4">
                        <div class="widget widget-table-four">
                            <div class="widget-content">
                                <div class="flex-space-between">
                                    <div>
                                        <img style="width: 80px" src="assets/img/icon/dashboard/allorder.png">
                                    </div>
                                    <div>
                                        <h4 class="inner-flex mb-2" style="color: #ED4880"><?php echo number_format($totalOrders) ?></h4>
                                        <h5 class="">Total Orders</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="user.php" class="col-sm-4">
                        <div class="widget widget-table-four">
                            <div class="widget-content">
                                <div class="flex-space-between">
                                    <div>
                                        <img style="width: 80px" src="assets/img/icon/dashboard/user.png">
                                    </div>
                                    <div>
                                        <h4 class="inner-flex mb-2" style="color: #F3A056"><?php echo number_format($totalUsers) ?></h4>
                                        <h5 class="">Total Users</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="row layout-top-spacing">
                    <a href="newOrder.php" class="col-sm-6">
                        <div class="widget widget-table-four">
                            <div class="widget-content">
                                <div class="flex-space-between">
                                    <div>
                                        <img style="width: 80px" src="assets/img/icon/dashboard/neworder.png">
                                    </div>
                                    <div>
                                        <h4 class="inner-flex mb-2" style="color: #EB5757"><?php echo number_format($newOrders1) ?></h4>
                                        <h5 class="">New Pre Orders</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="newOrder1.php" class="col-sm-6">
                        <div class="widget widget-table-four">
                            <div class="widget-content">
                                <div class="flex-space-between">
                                    <div>
                                        <img style="width: 80px" src="assets/img/icon/dashboard/neworder.png">
                                    </div>
                                    <div>
                                        <h4 class="inner-flex mb-2" style="color: #EB5757"><?php echo number_format($newOrders2) ?></h4>
                                        <h5 class="">New Instant Orders</h5>
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
                                <h5 class="">Revenue</h5>
                                <ul class="tabs tab-pills">
                                    <li><a id="tb_1" class="tabmenu">Past 12 Months</a></li>
                                </ul>
                            </div>

                            <div class="widget-content">
                                <div class="tabs tab-content">
                                    <div id="content_1" class="tabcontent"> 
                                        <div id="revenueMonthly"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-chart-two">
                            <div class="widget-heading">
                                <h5 class="">Sales by Category</h5>
                            </div>
                            <div class="widget-content">
                                <div id="chart-2" class=""></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-5 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget-two">
                            <div class="widget-content">
                                <div class="w-numeric-value">
                                    <div class="w-content">
                                        <span class="w-value">Daily sales</span>
                                        <span class="w-numeric-title">Go to columns for details.</span>
                                    </div>
                                    <div class="w-icon" style="padding: 10px 16px; color: #000000">₹</div>
                                </div>
                                <div class="w-chart">
                                    <div id="daily-sales"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-7 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-one_hybrid widget-followers">
                            <div class="widget-heading">
                                <h5 class="">New Users</h5>
                                <p>Past 7 days</p>
                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">

                            <div class="widget-heading">
                                <h5 class="">
                                    Top Users
                                    <a href="user.php" class="btn btn-outline-dark float-right">View All</a>
                                </h5>
                            </div>

                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content text-center">Customer</div></th>
                                                <th><div class="th-content text-center">Phone Number</div></th>
                                                <th><div class="th-content text-center">Email Id</div></th>
                                                <th><div class="th-content text-center">Total Order</div></th>
                                                <th><div class="th-content text-center">Registration</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if($control == 0){
                                                    $sql = "SELECT user_id,count(*) AS order_count FROM orders WHERE order_status='5' GROUP BY user_id ORDER BY count(*) DESC LIMIT 7";
                                                } else{
                                                    $sql = "SELECT user_id,count(*) AS order_count FROM orders WHERE order_status='5' AND login_id='$login_id' GROUP BY user_id ORDER BY count(*) DESC LIMIT 7";
                                                }
                                                $result = $conn->query($sql);
                                                if($result->num_rows > 0){
                                                    while($row = $result->fetch_assoc()){
                                                        $user_id = $row['user_id'];
                                                        $order_count = $row['order_count'];
    
                                                        $sql1 = "SELECT * FROM user WHERE user_id='$user_id'";
                                                        $result1 = $conn->query($sql1);
                                                        $row1 = $result1->fetch_assoc();
                                            ?>
                                                        <tr>
                                                            <td class="text-center"><div class="td-content customer-name"><?php echo ucfirst($row1['user_name']) ?></div></td>
                                                            <td class="text-center"><div class="td-content product-brand"><?php echo $row1['user_phone_number'] ?></div></td>
                                                            <td class="text-center"><div class="td-content"><?php echo $row1['user_email'] ?></div></td>
                                                            <td class="text-center"><div class="td-content"><span class=""><?php echo $order_count ?></span></div></td>
                                                            <td class="text-center"><div class="td-content"><?php echo date('d-m-Y', strtotime($row1['user_registration_date'])) ?></div></td>
                                                        </tr>
                                            <?php
                                                    }
                                                } else{
                                            ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center">
                                                            <p style="margin-bottom: 0px">No User Found</p>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">

                            <div class="widget-heading">
                                <h5 class="">
                                    Top Selling Product
                                    <a href="product-report.php" class="btn btn-outline-dark float-right">View All</a>
                                </h5>
                            </div>

                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Product</div></th>
                                                <th><div class="th-content text-center th-heading">Category</div></th>
                                                <th><div class="th-content text-center th-heading">Recommended</div></th>
                                                <th><div class="th-content text-center">Offer</div></th>
                                                <th><div class="th-content text-center">Quantity</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $product_array = array();
                                                $sql = "SELECT * FROM product ORDER BY product_name ASC";
                                                $result = $conn->query($sql);
                                                while($row = $result->fetch_assoc()){
                                                    $product_id = $row['product_id'];

                                                    $sql1 = "SELECT * FROM order_detail WHERE product_id='$product_id'";
                                                    $result1 = $conn->query($sql1);
                                                    while($row1 = $result1->fetch_assoc()){
                                                        $order_id = $row1['order_id'];

                                                        if($control == 0){
                                                            $sql2 = "SELECT * FROM orders WHERE order_id='$order_id' AND order_status='5'";
                                                        } else{
                                                            $sql2 = "SELECT * FROM orders WHERE order_id='$order_id' AND order_status='5' AND login_id='$login_id'";
                                                        }
                                                        $result2 = $conn->query($sql2);
                                                        if($result2->num_rows > 0){
                                                            $product_array[$product_id] += $row1['quantity'];
                                                        }
                                                    }
                                                }

                                                arsort($product_array);

                                                $i = 0;
                                                foreach($product_array as $product_id => $quantity){
                                                    if($i<7){
                                                        $sql = "SELECT * FROM product WHERE product_id='$product_id'";
                                                        $result = $conn->query($sql);
                                                        $row = $result->fetch_assoc();

                                                        $recom = $offer = 'No';
                                                        if($row['product_recommended'] == 1){
                                                            $recom = 'Yes';
                                                        }
                                                        if($row['product_offer'] == 1){
                                                            $offer = 'Yes';
                                                        }

                                                        $category_id = $row['category_id'];

                                                        $sql1 = "SELECT * FROM category WHERE category_id='$category_id'";
                                                        $result1 = $conn->query($sql1);
                                                        $row1 = $result1->fetch_assoc();
                                            ?>
                                                        <tr>
                                                            <td><div class="td-content product-name"><img src="<?php echo $row['product_image'] ?>"><?php echo $row['product_name'] ?></div></td>
                                                            <td><div class="td-content text-center"><span class="pricing"><?php echo $row1['category_name'] ?></span></div></td>
                                                            <td><div class="td-content text-center"><span class="discount-pricing"><?php echo $recom ?></span></div></td>
                                                            <td><div class="td-content text-center"><?php echo $offer ?></div></td>
                                                            <td><div class="td-content text-center"><?php echo $quantity ?></div></td>
                                                        </tr>
                                            <?php
                                                    }
                                                    $i++;
                                                }
                                                if($i == 0){
                                            ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center">
                                                            <p style="margin-bottom: 0px">No Product Found</p>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <?php include('include/footer.php') ?>
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
    <script src="plugins/apex/apexcharts.min.js"></script>
    <?php include('map.php') ?>
    <script src="assets/js/dashboard/dash_2.js"></script>
</body>
</html>