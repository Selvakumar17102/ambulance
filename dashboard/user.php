<?php
    ini_set('display_errors','off');
    include('include/connection.php');
    $users = 'active';
    $usersBoolean = 'true';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>All Users | Salvo Ambulance</title>
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
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
    <style>
        .dt-buttons{
            float: right;
        }
        /* #Table_paginate{
            padding: 0px 500px;
        } */
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
                    <div class="col-sm-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h4>All Users</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="table-responsive">
                                    <table class="table mb-4" id="Table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S.No</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Phone Number</th>
                                                <th class="text-center">Email Id</th>
                                                <th class="text-center">Alternate Phone Number</th>
                                                <th class="text-center">Registration Date</th>
                                                <th class="text-center">Blood Group</th>
                                                <th class="text-center">BP Level</th>
                                                <th class="text-center">Sugar Level</th>
                                                <th class="text-center">Thyroid</th>
                                                <th class="text-center">Asthma</th>
                                                <!-- <th class="text-center">Delivered Orders</th>
                                                <th class="text-center">Cancelled Orders</th> -->
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql = "SELECT * FROM user ORDER BY user_registration_date DESC";
                                                $result = $conn->query($sql);
                                                $count = 1;
                                                while($row = $result->fetch_assoc()){
                                                    $user_id = $row['user_id'];
                                                    $membership_id = $row['membership_id'];
                                                    $membership_name = $expiry_date = "";
                                                    $free_delivery = 0;

                                                    $del = $can = 0;

                                                    $status = '';
                                                    if($row['user_status'] == 1){
                                                        $status = 'checked';
                                                    }
                                                    $sql1 = "SELECT * FROM orders WHERE user_id='$user_id'";
                                                    $result1 = $conn->query($sql1);
                                                    while($row1 = $result1->fetch_assoc()){
                                                        if($row1['order_status'] == 5){
                                                            $del++;
                                                        }else{
                                                            if($row1['order_status'] == 0){
                                                                $can++;
                                                            }
                                                        }
                                                    }

                                                    $thyroid = $asthma = $bp_level = $sugar_level = "No";

                                                    if($row['thyroid']){
                                                        $thyroid = "Yes";
                                                    }

                                                    if($row['asthma']){
                                                        $asthma = "Yes";
                                                    }

                                                    if($row['bp_level']){
                                                        $bp_level = "Yes";
                                                    }

                                                    if($row['sugar_level']){
                                                        $sugar_level = "Yes";
                                                    }
                                            ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $count++ ?></td>
                                                        <td class="text-center"><?php echo $row['user_name'] ?></td>
                                                        <td class="text-center"><img src="<?php echo $row['user_profile'] ?>" alt="User Profile" width="50" height="50"></td>
                                                        <td class="text-center"><?php echo $row['user_phone_number'] ?></td>
                                                        <td class="text-center"><?php echo $row['user_email'] ?></td>
                                                        <td class="text-center"><?php echo $row['user_alternate_phone_number'] ?></td>
                                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($row['user_registration_date'])) ?></td>
                                                        <td class="text-center"><?php echo $row['blood_group'] ?></td>
                                                        <td class="text-center"><?php echo $bp_level ?></td>
                                                        <td class="text-center"><?php echo $sugar_level ?></td>
                                                        <td class="text-center"><?php echo $thyroid ?></td>
                                                        <td class="text-center"><?php echo $asthma ?></td>
                                                        <!-- <td class="text-center"><a href="user-deliveryOrder.php?id=<?php echo $user_id;?>"><?php echo $del ?></a></td>
                                                        <td class="text-center"><a href="user-cancelOrder.php?id=<?php echo $user_id;?>"><?php echo $can ?></a></td> -->
                                                        <td class="text-center">
                                                            <label class="switch s-icons s-outline s-outline-success" style="margin-bottom: 0px !important">
                                                                <input type="checkbox" id="S<?php echo $row['user_id'] ?>" <?php echo $status ?> onclick="return userStatus(<?php echo $row['user_id'] ?>)">
                                                                <span class="slider round"></span>
                                                            </label>
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
    <script src="plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="plugins/table/datatable/button-ext/jszip.min.js"></script>    
    <script src="plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="plugins/table/datatable/button-ext/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/manual.js"></script>
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>
    <script>
        $("#Table").DataTable({
            dom: 'lBfrtip',
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn' },
                    { extend: 'csv', className: 'btn' },
                    { extend: 'excel', className: 'btn' },
                ]
            },
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [50, 100, 200, 300],
            "pageLength": 50 
        })
	</script>
</body>
</html>