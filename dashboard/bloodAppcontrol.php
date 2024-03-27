<?php
    include('include/connection.php');
    $blood = 'active';
    $bloodBoolean = 'true';
    $bloodShow = 'show';
	$bloodapp = 'active';

    if(isset($_POST['add'])){
        $request_km = $_POST['request_km'];
        $bank_km = $_POST['bank_km'];
        $content_msg = $_POST['content_msg'];

        $sql = "UPDATE blood_app_control SET request_km='$request_km',bank_km='$bank_km',content_msg='$content_msg' WHERE id='1'";
        if($conn->query($sql) === TRUE){
            header('Location: bloodAppcontrol.php?msg=Controls updated!');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Blood App Controls | Salvo Ambulance</title>
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
                                        <h4>Salvo Ambulance</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form method="post" enctype="multipart/form-data">
                                    <?php
                                        $sql = "SELECT * FROM blood_app_control WHERE id='1'";
                                        $result = $conn->query($sql);
                                        $row = $result->fetch_assoc();
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-4 mt-2">
                                            <label>Blood Request Min Km</label>
                                            <input type="number" min='0' name="request_km" id="request_km" class="form-control" placeholder="Blood Request Min Km" value="<?php echo $row['request_km'] ?>" onkeyup="setPercentValue()">
                                        </div>
                                        <div class="col-sm-4 mt-2">
                                            <label>Bank km</label>
                                            <input type="number" name="bank_km" id="bank_km" class="form-control" placeholder="Bank km" value="<?php echo $row['bank_km'] ?>">
                                        </div>
                                        <div class="col-sm-4 mt-2">
                                            <label>Service available content</label>
                                            <input type="text" name="content_msg" id="content_msg" class="form-control" placeholder="Service available content" value="<?php echo $row['content_msg'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <input type="submit" name="add" value="Update" class="float-right btn btn-primary mr-4 mt-4">
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
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/manual.js"></script>
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>
    <script>
        function setPercentValue() {
            let percent = document.getElementById('request_km')
            let amount = document.getElementById('amount_to_client')

            if(percent.value){
                amount.value = 0
            }
        }
        function setAmountValue() {
            let percent = document.getElementById('request_km')
            let amount = document.getElementById('amount_to_client')

            if(amount.value){
                percent.value = 0
            }
        }
    </script>
</body>
</html>