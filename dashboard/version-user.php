<?php
    ini_set('display_errors','off');
    include('include/connection.php');

    $report = 'active';
    $reportShow = 'show';
    $reportBoolean = 'true';
    $versionReport = 'active';

    $id = $_REQUEST['id'];

    $sql = "SELECT * FROM app_version WHERE app_version_id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $app_version_name = $row['app_version_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Version - <?php echo $app_version_name ?> Users | Salvo Ambulance</title>
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
                                        <h4>Version - <?php echo $app_version_name ?> Users</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-striped mb-4 convert-data-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S.No</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Phone Number</th>
                                                <th class="text-center">Email Id</th>
                                                <th class="text-center">Alternate Phone Number</th>
                                                <th class="text-center">Registration Date</th>
                                                <th class="text-center">Current Version</th>
                                                <th class="text-center">Last Updated Date</th>
                                                <th class="text-center">Delivered Orders</th>
                                                <th class="text-center">Cancelled Orders</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql = "SELECT * FROM user WHERE user_name!='' AND version='$app_version_name' ORDER BY user_registration_date DESC";
                                                $result = $conn->query($sql);
                                                $count = 1;
                                                while($row = $result->fetch_assoc()){
                                                    $user_id = $row['user_id'];
                                                    $del = $can = 0;
                                                    $sql1 = "SELECT * FROM orders WHERE user_id='$user_id'";
                                                    $result1 = $conn->query($sql1);
                                                    while($row1 = $result1->fetch_assoc()){
                                                        if($row1['order_status'] == 5){
                                                            $del++;
                                                        } else{
                                                            if($row['order_status'] == 0){
                                                                $can++;
                                                            }
                                                        }
                                                    }
                                            ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $count++ ?></td>
                                                        <td class="text-center"><?php echo $row['user_name'] ?></td>
                                                        <td class="text-center"><?php echo $row['user_phone_number'] ?></td>
                                                        <td class="text-center"><?php echo $row['user_email'] ?></td>
                                                        <td class="text-center"><?php echo $row['user_alternate_phone_number'] ?></td>
                                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($row['user_registration_date'])) ?></td>
                                                        <td class="text-center"><?php echo $row['version'] ?></td>
                                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($row['last_updated_date'])) ?></td>
                                                        <td class="text-center"><a href="user-deliveryOrder.php?id=<?php echo $user_id;?>"><?php echo $del ?></a></td>
                                                        <td class="text-center"><a href="user-cancelOrder.php?id=<?php echo $user_id;?>"><?php echo $can ?></a></td>
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
    <script src="plugins/table/datatable/datatables.js"></script>
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