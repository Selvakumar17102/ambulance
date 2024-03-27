<?php
    ini_set('display_errors','on');
    include('include/connection.php');
    $blood = 'active';
    $bloodBoolean = 'true';
    $bloodShow = 'show';
	$bloodrequest = 'active';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Blood Request | Salvo Ambulance</title>
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
                                    <div class="col-sm-9">
                                        <h4>Blood Request List</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="table-responsive">
                                    <table class="table mb-4 convert-data-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">patient Name</th>
                                                <th class="text-center">Age</th>
                                                <th class="text-center">Blood Gruop</th>
                                                <th class="text-center">phone No</th>
                                                <th class="text-center">Alter phone No</th>
                                                <!-- <th class="text-center">city</th> -->
                                                <th class="text-center">Request Date</th>
                                                <th class="text-center">Unit</th>
                                                <th class="text-center">Hospital location</th>
                                                <th class="text-center">Emergency status</th>
                                                <!-- <th class="text-center">Additional notes</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql = "SELECT * FROM blood_request a 
                                                LEFT OUTER JOIN user b ON a.user_id=b.user_id 
                                                LEFT OUTER JOIN city c ON a.request_city_id=c.city_id
                                                LEFT OUTER JOIN bloodlist d ON a.blood_group=d.blood_id";
                                                $result = $conn->query($sql);
                                                $count = 0;
                                                while($row = $result->fetch_assoc())
                                                {
                                                    $request_id = $row['blood_request_id'];

                                                    if($row['emergency_status'] == 1){
                                                        $status = '<span class="badge outline-badge-danger">Emergency</span>';
                                                    } else{
                                                        $status = '<span class="badge outline-badge-primary">Non-Emergency</span>';
                                                    }
                                                
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo ++$count ?></td>
                                                    <td class="text-center"><?php echo $row['patient_name'] ?></td>
                                                    <td class="text-center"><?php echo $row['age'] ?></td>
                                                    <td class="text-center"><b><?php echo $row['blood_name'] ?></b></td>
                                                    <td class="text-center"><?php echo $row['phone_no'] ?></td>
                                                    <td class="text-center"><?php echo $row['alter_phone_no'] ?></td>
                                                    <!-- <td class="text-center"><?php echo $row['city_name'] ?></td> -->
                                                    <td class="text-center"><?php echo $row['request_date'] ?></td>
                                                    <td class="text-center"><b><?php echo $row['unit'] ?></b></td>
                                                    <td class="text-center"><?php echo $row['hospital_location'] ?></td>
                                                    <td class="text-center"><?php echo $status ?></td>
                                                    <!-- <td class="text-center"><?php echo $row['additional_notes'] ?></td> -->
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