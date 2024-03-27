<?php
    ini_set('display_errors','off');
    include('include/connection.php');
    $menu = 'active';
	$menuShow = 'show';
	$menuBoolean = 'true';
	$ambulanceDriverBoolean = 'true';
	$ambulanceDriver = 'active';

    $id = $_REQUEST['id'];

    $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php echo $row['delivery_partner_name'] ?> Documents | Salvo Ambulance</title>
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
                                        <h4><?php echo $row['delivery_partner_name'] ?> Documents</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row" style="border-bottom-style: double;border-bottom-color: #000000;display: flex;align-items: center;justify-content: center; padding: 10px">
                                                <div class="col-sm-1">
                                                    <label style="font-size: large;font-weight: bold;color:#000000ba">License:</label>
                                                </div>
                                                <div class="col-sm-11">
                                                    <?php
                                                        $sql5 = "SELECT * FROM driver_image_file WHERE driver_id = '$id' AND image!='' AND type=1";
                                                        $result5 = $conn->query($sql5);
                                                        while($driverImageTable = $result5->fetch_assoc()){
                                                    ?>
                                                            <!-- <img style="height: 50px;width:50px;" src="<?php echo $driverImageTable['image'] ?>" alt="License Images"> -->
                                                            <a target="_blank" href="<?php echo $driverImageTable['image'] ?>"><img src="<?php echo $driverImageTable['image'] ?>" alt="License" width="70" height="70"></a>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row" style="border-bottom-style: double;border-bottom-color: #000000;display: flex;align-items: center;justify-content: center; padding: 10px">
                                                <div class="col-sm-1">
                                                    <label style="font-size: large;font-weight: bold;color:#000000ba">RC Book:</label>
                                                </div>
                                                <div class="col-sm-11">
                                                    <?php
                                                        $sql5 = "SELECT * FROM driver_image_file WHERE driver_id = '$id' AND image!='' AND type=2";
                                                        $result5 = $conn->query($sql5);
                                                        while($driverImageTable = $result5->fetch_assoc()){
                                                    ?>
                                                            <!-- <img style="height: 50px;width:50px;" src="<?php echo $driverImageTable['image'] ?>" alt="RC Book Images"> -->
                                                            <a target="_blank" href="<?php echo $driverImageTable['image'] ?>"><img src="<?php echo $driverImageTable['image'] ?>" alt="RC Book" width="70" height="70"></a>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row" style="border-bottom-style: double;border-bottom-color: #000000;display: flex;align-items: center;justify-content: center; padding: 10px">
                                                <div class="col-sm-1">
                                                    <label style="font-size: large;font-weight: bold;color:#000000ba">Vehicle Image:</label>
                                                </div>
                                                <div class="col-sm-11">
                                                    <?php
                                                        $sql5 = "SELECT * FROM driver_image_file WHERE driver_id = '$id' AND image!='' AND type=3";
                                                        $result5 = $conn->query($sql5);
                                                        while($driverImageTable = $result5->fetch_assoc()){
                                                    ?>
                                                            <!-- <img style="height: 50px;width:50px;" src="<?php echo $driverImageTable['image'] ?>" alt="Vehicle Images"> -->
                                                            <a target="_blank" href="<?php echo $driverImageTable['image'] ?>"><img src="<?php echo $driverImageTable['image'] ?>" alt="Vehicle" width="70" height="70"></a>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row" style="display: flex;align-items: center;justify-content: center; padding: 10px">
                                                <div class="col-sm-1">
                                                    <label style="font-size: large;font-weight: bold;color:#000000ba">Aadhaar:</label>
                                                </div>
                                                <div class="col-sm-11">
                                                    <?php
                                                        $sql5 = "SELECT * FROM driver_image_file WHERE driver_id = '$id' AND image!='' AND type=4";
                                                        $result5 = $conn->query($sql5);
                                                        while($driverImageTable = $result5->fetch_assoc()){
                                                    ?>
                                                            <!-- <img style="height: 50px;width:50px;" src="<?php echo $driverImageTable['image'] ?>" alt="Vehicle Images"> -->
                                                            <a target="_blank" href="<?php echo $driverImageTable['image'] ?>"><img src="<?php echo $driverImageTable['image'] ?>" alt="Aadhar" width="70" height="70"></a>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/manual.js"></script>
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>
</body>
</html>