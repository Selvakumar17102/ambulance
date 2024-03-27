<?php
    ini_set('display_errors','off');
    include('include/connection.php');
    include('../api/onesignaldelivery.php');

    $menu = 'active';
	$menuShow = 'show';
	$menuBoolean = 'true';
	$ambulanceDriverRequestBoolean = 'true';
	$ambulanceDriverRequest = 'active';

    if(isset($_POST['accept'])){
        $delivery_partner_id = $_REQUEST['delivery_partner_id'];

        $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $riderTable = $result->fetch_assoc();

            $title = 'Hi '.$riderTable['delivery_partner_name'];

            $sql = "UPDATE delivery_partner SET request_status = 2 WHERE delivery_partner_id='$delivery_partner_id'";
            $conn->query($sql);

            sendNotificationDelivery($delivery_partner_id, $title, 'Your request has been accepted', '', '0', '0', '');

            header('Location: ambulanceDriverRequest.php?msg=Accepted!');
        }
    }

    if(isset($_POST['delete'])){
        $delivery_partner_id = $_REQUEST['delivery_partner_id'];

        $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $riderTable = $result->fetch_assoc();

            $title = 'Hi '.$riderTable['delivery_partner_name'];

            $sql = "UPDATE delivery_partner SET request_status = 0 WHERE delivery_partner_id='$delivery_partner_id'";
            $conn->query($sql);

            sendNotificationDelivery($delivery_partner_id, $title, 'Your request has been rejected', '', '0', '0', '');

            header('Location: ambulanceDriverRequest.php?msg=Rejected!');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Driver Request | Salvo Ambulance</title>
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
        #map{
            width: 100%;
            height: 400px;
            background-color: grey;
        }
        .dt-buttons{
            float: right;
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
                    <div class="col-sm-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h4>Driver Request</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <a data-toggle="modal" id="mapShow" data-target="#mapLoader" style="display: none"></a>
                                <div class="modal fade" id="mapLoader" tabindex="-1" role="dialog" aria-labelledby="mapView" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <form method="post" enctype="multipart/form-data">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="mapView"></h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="map"></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mb-4" id="Table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S.No</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Address</th>
                                                <th class="text-center">Phone Number</th>
                                                <th class="text-center">Date Of Birth</th>
                                                <th class="text-center">Blood Group</th>
                                                <th class="text-center">Email Id</th>
                                                <th class="text-center">Gender</th>
                                                <th class="text-center">Alternate Phone Number</th>
                                                <th class="text-center">Registration Date</th>
                                                <th class="text-center">City</th>
                                                <th class="text-center">Emergency Acceptable</th>
                                                <th class="text-center">Vehicle Type</th>
                                                <th class="text-center">Vehicle Name</th>
                                                <th class="text-center">Vehicle Number</th>
                                                <th class="text-center">License Number</th>
                                                <th class="text-center">Aadhaar Number</th>
                                                <th class="text-center">Local Charge (₹)</th>
                                                <th class="text-center">Local Min Distance</th>
                                                <th class="text-center">Local Extra Charge Per Km (₹)</th>
                                                <th class="text-center">Long Min Distance</th>
                                                <th class="text-center">Long Charge (₹)</th>
                                                <th class="text-center">Long Max Distance</th>
                                                <th class="text-center">Long Extra Charge Per Km (₹)</th>
                                                <th class="text-center">Documents</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if($control == 0){
                                                    $sql = "SELECT * FROM delivery_partner WHERE request_status = 1 ORDER BY delivery_partner_registration_date DESC";
                                                } else{
                                                    $sql = "SELECT * FROM delivery_partner WHERE request_status = 1 AND delivery_partner_branch_id='$login_id' ORDER BY delivery_partner_registration_date DESC";
                                                }
                                                $result = $conn->query($sql);
                                                $count = 1;
                                                while($row = $result->fetch_assoc()){
                                                    $delivery_partner_id = $row['delivery_partner_id'];
                                                    $delivery_partner_branch_id = $row['delivery_partner_branch_id'];
                                                    $delivery_partner_online_status = $row['delivery_partner_online_status'];
                                                    $vehicle_type = $row['vehicle_type'];
                                                    $emergency = $row['emergency'];

                                                    $isemergency = "Non-Emergency";
                                                    if($emergency == 1){
                                                        $isemergency = "Emergency";
                                                    } elseif ($emergency == 2){
                                                        $isemergency = "Both";
                                                    }

                                                    $sql1 = "SELECT * FROM category WHERE category_id='$vehicle_type'";
                                                    $result1 = $conn->query($sql1);
                                                    $row1 = $result1->fetch_assoc();

                                                    $sql2 = "SELECT * FROM branch WHERE login_id='$delivery_partner_branch_id'";
                                                    $result2 = $conn->query($sql2);
                                                    $row2 = $result2->fetch_assoc();
                                            ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $count++ ?></td>
                                                        <td class="text-center">
                                                            <span onclick='loadmap(<?php echo $delivery_partner_id ?>)'><?php echo ucfirst($row['delivery_partner_name']) ?></span>
                                                            <input type="hidden" id="lat<?php echo $delivery_partner_id ?>" value="<?php echo $row['delivery_partner_latitude'] ?>">
                                                            <input type="hidden" id="long<?php echo $delivery_partner_id ?>" value="<?php echo $row['delivery_partner_longitude'] ?>">
                                                        </td>
                                                        <td class="text-center"><img style="width: 100px" src="<?php echo $row['delivery_partner_image'] ?>"></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_address'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_phone'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_date_of_birth'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_blood_group'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_email'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_gender'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_alternate_mobile'] ?></td>
                                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($row['delivery_partner_registration_date'])) ?></td>
                                                        <td class="text-center"><?php echo $row2['branch_name'] ?></td>
                                                        <td class="text-center"><?php echo $isemergency ?></td>
                                                        <td class="text-center"><?php echo $row1['category_name'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_vehicle_name'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_vehicle_number'] ?></td>
                                                        <td class="text-center"><?php echo $row['license_number'] ?></td>
                                                        <td class="text-center"><?php echo $row['aadhaar_number'] ?></td>
                                                        <td class="text-center"><?php echo $row['local_charge'] ?></td>
                                                        <td class="text-center"><?php echo $row['local_min_distance'] ?></td>
                                                        <td class="text-center"><?php echo $row['local_extra_charge_per_km'] ?></td>
                                                        <td class="text-center"><?php echo $row['long_min_distance'] ?></td>
                                                        <td class="text-center"><?php echo $row['long_charge'] ?></td>
                                                        <td class="text-center"><?php echo $row['long_max_distance'] ?></td>
                                                        <td class="text-center"><?php echo $row['long_extra_charge_per_km'] ?></td>
                                                        <td class="text-center"><a target="_blank" class="btn btn-secondary" href="driverDocuments.php?id=<?php echo $delivery_partner_id ?>">View</a></td>
                                                        <td class="text-center">
                                                            <ul class="table-controls">
                                                                <li>
                                                                    <a data-toggle="modal" data-target="#acceptAdmin<?php echo $delivery_partner_id ?>" class="btn btn-success p-2">
                                                                        <span style="font-weight: 900">Accept</span>
                                                                    </a>
                                                                    <div class="modal fade" id="acceptAdmin<?php echo $delivery_partner_id ?>" tabindex="-1" role="dialog" aria-labelledby="acceptAdminTitle" style="display: none;" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <form method="post">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="acceptAdminTitle">Accept Driver</h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <p class="modal-text">Are you sure to accpet this driver <?php echo ucfirst($row['delivery_partner_name']) ?>!</p>
                                                                                        <input type="hidden" name="delivery_partner_id" value="<?php echo $delivery_partner_id ?>">
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button class="btn" data-dismiss="modal"> No</button>
                                                                                        <button type="submit" name="accept" class="btn btn-success">Accept</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="mt-1">
                                                                    <a data-toggle="modal" data-target="#deleteAdmin<?php echo $delivery_partner_id ?>" class="btn btn-danger p-2">
                                                                        <span style="font-weight: 900">Reject</span>
                                                                    </a>
                                                                    <div class="modal fade" id="deleteAdmin<?php echo $delivery_partner_id ?>" tabindex="-1" role="dialog" aria-labelledby="addAdminTitle" style="display: none;" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <form method="post">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="addAdminTitle">Reject Driver</h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                    <p class="modal-text">Are you sure to reject this driver <?php echo ucfirst($row['delivery_partner_name']) ?>!</p>
                                                                                        <input type="hidden" name="delivery_partner_id" value="<?php echo $delivery_partner_id ?>">
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button class="btn" data-dismiss="modal"> No</button>
                                                                                        <button type="submit" name="delete" class="btn btn-danger">Reject</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
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
                <div class="row layout-top-spacing">
                    <?php include('include/notification.php') ?>
                    <div class="col-sm-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h4>Rejected Driver</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <a data-toggle="modal" id="mapShow" data-target="#mapLoader" style="display: none"></a>
                                <div class="modal fade" id="mapLoader" tabindex="-1" role="dialog" aria-labelledby="mapView" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <form method="post" enctype="multipart/form-data">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="mapView"></h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="map"></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mb-4" id="Table1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S.No</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Address</th>
                                                <th class="text-center">Phone Number</th>
                                                <th class="text-center">Date Of Birth</th>
                                                <th class="text-center">Blood Group</th>
                                                <th class="text-center">Email Id</th>
                                                <th class="text-center">Gender</th>
                                                <th class="text-center">Alternate Phone Number</th>
                                                <th class="text-center">Registration Date</th>
                                                <th class="text-center">City</th>
                                                <th class="text-center">Emergency Acceptable</th>
                                                <th class="text-center">Vehicle Type</th>
                                                <th class="text-center">Vehicle Name</th>
                                                <th class="text-center">Vehicle Number</th>
                                                <th class="text-center">License Number</th>
                                                <th class="text-center">Aadhaar Number</th>
                                                <th class="text-center">Local Charge (₹)</th>
                                                <th class="text-center">Local Min Distance</th>
                                                <th class="text-center">Local Extra Charge Per Km (₹)</th>
                                                <th class="text-center">Long Min Distance</th>
                                                <th class="text-center">Long Charge (₹)</th>
                                                <th class="text-center">Long Max Distance</th>
                                                <th class="text-center">Long Extra Charge Per Km (₹)</th>
                                                <th class="text-center">Documents</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if($control == 0){
                                                    $sql = "SELECT * FROM delivery_partner WHERE request_status = 0 ORDER BY delivery_partner_registration_date DESC";
                                                } else{
                                                    $sql = "SELECT * FROM delivery_partner WHERE request_status = 0 AND delivery_partner_branch_id='$login_id' ORDER BY delivery_partner_registration_date DESC";
                                                }
                                                $result = $conn->query($sql);
                                                $count = 1;
                                                while($row = $result->fetch_assoc()){
                                                    $delivery_partner_id = $row['delivery_partner_id'];
                                                    $delivery_partner_branch_id = $row['delivery_partner_branch_id'];
                                                    $delivery_partner_online_status = $row['delivery_partner_online_status'];
                                                    $vehicle_type = $row['vehicle_type'];
                                                    $emergency = $row['emergency'];

                                                    $isemergency = "Non-Emergency";
                                                    if($emergency == 1){
                                                        $isemergency = "Emergency";
                                                    } elseif ($emergency == 2){
                                                        $isemergency = "Both";
                                                    }

                                                    $sql1 = "SELECT * FROM category WHERE category_id='$vehicle_type'";
                                                    $result1 = $conn->query($sql1);
                                                    $row1 = $result1->fetch_assoc();

                                                    $sql2 = "SELECT * FROM branch WHERE login_id='$delivery_partner_branch_id'";
                                                    $result2 = $conn->query($sql2);
                                                    $row2 = $result2->fetch_assoc();
                                            ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $count++ ?></td>
                                                        <td class="text-center">
                                                            <span onclick='loadmap(<?php echo $delivery_partner_id ?>)'><?php echo ucfirst($row['delivery_partner_name']) ?></span>
                                                            <input type="hidden" id="lat<?php echo $delivery_partner_id ?>" value="<?php echo $row['delivery_partner_latitude'] ?>">
                                                            <input type="hidden" id="long<?php echo $delivery_partner_id ?>" value="<?php echo $row['delivery_partner_longitude'] ?>">
                                                        </td>
                                                        <td class="text-center"><img style="width: 100px" src="<?php echo $row['delivery_partner_image'] ?>"></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_address'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_phone'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_date_of_birth'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_blood_group'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_email'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_gender'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_alternate_mobile'] ?></td>
                                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($row['delivery_partner_registration_date'])) ?></td>
                                                        <td class="text-center"><?php echo $row2['branch_name'] ?></td>
                                                        <td class="text-center"><?php echo $isemergency ?></td>
                                                        <td class="text-center"><?php echo $row1['category_name'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_vehicle_name'] ?></td>
                                                        <td class="text-center"><?php echo $row['delivery_partner_vehicle_number'] ?></td>
                                                        <td class="text-center"><?php echo $row['license_number'] ?></td>
                                                        <td class="text-center"><?php echo $row['aadhaar_number'] ?></td>
                                                        <td class="text-center"><?php echo $row['local_charge'] ?></td>
                                                        <td class="text-center"><?php echo $row['local_min_distance'] ?></td>
                                                        <td class="text-center"><?php echo $row['local_extra_charge_per_km'] ?></td>
                                                        <td class="text-center"><?php echo $row['long_min_distance'] ?></td>
                                                        <td class="text-center"><?php echo $row['long_charge'] ?></td>
                                                        <td class="text-center"><?php echo $row['long_max_distance'] ?></td>
                                                        <td class="text-center"><?php echo $row['long_extra_charge_per_km'] ?></td>
                                                        <td class="text-center"><a target="_blank" class="btn btn-secondary" href="driverDocuments.php?id=<?php echo $delivery_partner_id ?>">View</a></td>
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
    <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDsZfyPkdAYDlHUBr56Q4ReAjuHmrJBHmY"></script> -->
    <script>
        $(document).ready(function() {
            App.init();
        });
        function initMap(id){
            var uluru = {
                lat: parseFloat(document.getElementById('lat'+id).value),
                lng: parseFloat(document.getElementById('long'+id).value)
            }
            var map = new google.maps.Map(
                document.getElementById('map'),
                {
                    zoom: 18,
                    center: uluru
                }
            );
            var marker = new google.maps.Marker({
                position: uluru,
                icon: {url: "assets/img/icon/map.png", scaledSize: new google.maps.Size(70, 70)},
                map: map
            });
        }
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
        $("#Table1").DataTable({
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