<?php
    ini_set('display_errors','off');
    include('include/connection.php');
    $menu = 'active';
	$menuShow = 'show';
	$menuBoolean = 'true';
	$ambulanceDriverBoolean = 'true';
	$ambulanceDriver = 'active';

    // if(isset($_POST['delete'])){
    //     $delivery_partner_id = $_POST['delivery_partner_id'];

    //     $sql2 = "SELECT delivery_partner_image FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
    //     $result2 = $conn->query($sql2);
    //     $driverTable = $result2->fetch_assoc();

    //     unlink($driverTable['delivery_partner_image']);

    //     $sql2 = "SELECT * FROM driver_image_file WHERE driver_id='$delivery_partner_id'";
    //     $result2 = $conn->query($sql2);
    //     while($driverTable = $result2->fetch_assoc()){
    //         unlink($driverTable['image']);
    //     }

    //     $sql = "DELETE FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
    //     if($conn->query($sql) === TRUE){
    //         $sql = "DELETE FROM driver_image_file WHERE driver_id='$delivery_partner_id'";
    //         if($conn->query($sql) === TRUE){
    //             header("Location: ambulanceDriver.php?msg=Deleted");
    //         }
    //     }
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Accepted Drivers | Salvo Ambulance</title>
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
                                        <h4>Accepted Drivers</h4>
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
                                                <th class="text-center">Completed Trips</th>
                                                <th class="text-center">Driver Total Earning (₹)</th>
                                                <th class="text-center">Client Total Earning (₹)</th>
                                                <!-- <th class="text-center">Payment From Driver (₹)</th>
                                                <th class="text-center">Payment To Driver (₹)</th> -->
                                                <th class="text-center">Online Status</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if($control == 0){
                                                    $sql = "SELECT * FROM delivery_partner WHERE request_status = 2 ORDER BY delivery_partner_registration_date DESC";
                                                } else{
                                                    $sql = "SELECT * FROM delivery_partner WHERE request_status = 2 AND delivery_partner_branch_id='$login_id' ORDER BY delivery_partner_registration_date DESC";
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
                                                    $catTable = $result1->fetch_assoc();

                                                    if($delivery_partner_online_status){
                                                        $onineStatus = '<span class="badge outline-badge-success">Online</span>';
                                                    } else{
                                                        $onineStatus = '<span class="badge outline-badge-danger">Offline</span>';
                                                    }
                                                    $status = $delivery_partner_online_status = '';
                                                    if($row['delivery_partner_status'] == 1){
                                                        $status = 'checked';
                                                    }
                                                    if($row['delivery_partner_online_status'] == 1){
                                                        $delivery_partner_online_status = 'checked';
                                                    }
                                                    $del = 0;
                                                    $totalAmount = $clientAmount = 0;
                                                    $sql1 = "SELECT * FROM orders WHERE delivery_partner_id='$delivery_partner_id'";
                                                    $result1 = $conn->query($sql1);
                                                    while($row1 = $result1->fetch_assoc()){
                                                        if($row1['order_status'] == 7){
                                                            $totalAmount += $row1['total_amount'];
                                                            $clientAmount += $row1['amount_for_client'];

                                                            $del++;
                                                        }
                                                    }
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
                                                        <td class="text-center"><?php echo $catTable['category_name'] ?></td>
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
                                                        <td class="text-center"><?php echo $del ?></td>
                                                        <td class="text-center"><?php echo $totalAmount - $clientAmount ?></td>
                                                        <td class="text-center"><?php echo $clientAmount ?></td>
                                                        <!-- <td class="text-center"><a href="paymentFromDriverLog.php?id=<?php echo $delivery_partner_id ?>"><?php echo $row['amount_to_client'] ?></a></td>
                                                        <td class="text-center"><a href="paymentToDriverLog.php?id=<?php echo $delivery_partner_id ?>"><?php echo $row['amount_from_client'] ?></a></td> -->
                                                        <td class="text-center"><?php echo $onineStatus ?></td>
                                                        <!-- <td class="text-center">
                                                            <label class="switch s-icons s-outline s-outline-success mr-2" style="margin-bottom: 0px !important">
                                                                <input type="checkbox" id="S<?php echo $delivery_partner_id ?>" <?php echo $delivery_partner_online_status ?> onclick="return deliveryPartnerOnlineStatus(<?php echo $delivery_partner_id ?>)">
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td> -->
                                                        <td class="text-center">
                                                            <label class="switch s-icons s-outline s-outline-success mr-2" style="margin-bottom: 0px !important">
                                                                <input type="checkbox" id="S<?php echo $delivery_partner_id ?>" <?php echo $status ?> onclick="return deliveryPartnerStatus(<?php echo $delivery_partner_id ?>)">
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                        <td class="text-center">
                                                            <ul class="table-controls">
                                                                <li>
                                                                    <a target="_blank" href="editAmbulanceDriver.php?id=<?php echo $delivery_partner_id ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
                                                                </li>
                                                                <!-- <li>
                                                                    <a data-toggle="modal" data-target="#deleteAdmin<?php echo $delivery_partner_id ?>">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                                                    </a>
                                                                    <div class="modal fade" id="deleteAdmin<?php echo $delivery_partner_id ?>" tabindex="-1" role="dialog" aria-labelledby="addAdminTitle" style="display: none;" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <form method="post">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="addAdminTitle">Delete Driver</h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <p class="modal-text">Are you sure to delete <?php echo $row["delivery_partner_name"] ?>!</p>
                                                                                        <input type="hidden" name="delivery_partner_id" value="<?php echo $delivery_partner_id ?>">
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button class="btn" data-dismiss="modal"> No</button>
                                                                                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li> -->
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
	</script>
</body>
</html>