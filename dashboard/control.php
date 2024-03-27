<?php
    include('include/connection.php');
    $setting = 'active';
    $settingShow = 'show';
    $settingBoolean = 'true';
    $control = 'active';

    if(isset($_POST['add'])){
        $percentage_to_client = $_POST['percentage_to_client'];
        $customer_care_no = $_POST['customer_care_no'];
        // $amount_to_client = $_POST['amount_to_client'];
        $service_not_available_content = $_POST['service_not_available_content'];
        $upi_qr_code = $_FILES['upi_qr_code']['name'];

        $sql = "UPDATE app_control SET percentage_to_client='$percentage_to_client',service_not_available_content='$service_not_available_content', customer_care_no = '$customer_care_no' WHERE app_control_id = '1'";
        if($conn->query($sql) === TRUE){
            
            $sql = "SELECT * FROM app_control WHERE app_control_id='1'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            if($upi_qr_code){
                if(is_file($row['upi_qr_code'])){
                    $upi_qrr_code = $row['upi_qr_code'];
                }
                $type=pathinfo($_FILES['upi_qr_code']['name'],PATHINFO_EXTENSION);

                $randomid = mt_rand(100,99999);
                $path="Images/Category/$randomid.$type";
                $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG');
                if(in_array($type, $allowTypes)){
                    if(move_uploaded_file($_FILES["upi_qr_code"]["tmp_name"], $path)){
                        $sql2 = "UPDATE app_control SET upi_qr_code = '$path' WHERE app_control_id='1'";
                        $conn->query($sql2);
                        unlink($upi_qrr_code);
                        header('Location: control.php?msg=Controls updated!');
                    } 
                }
            }

            header('Location: control.php?msg=Controls updated!');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>App Controls | Salvo Ambulance</title>
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
                                        <h4>Instant Ambulance</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form method="post" enctype="multipart/form-data">
                                    <?php
                                        $sql = "SELECT * FROM app_control WHERE app_control_id='1'";
                                        $result = $conn->query($sql);
                                        $row = $result->fetch_assoc();
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-6 mt-2">
                                            <label>Percentage (%)</label>
                                            <input type="number" min='0' name="percentage_to_client" id="percentage_to_client" class="form-control" placeholder="Percentage (%)" value="<?php echo $row['percentage_to_client'] ?>" onkeyup="setPercentValue()">
                                        </div>
                                        <!-- <div class="col-sm-6 mt-2">
                                            <label>Amount (₹)</label>
                                            <input type="number" min='0' name="amount_to_client" id="amount_to_client" class="form-control" placeholder="Amount (₹)" value="<?php echo $row['amount_to_client'] ?>" onkeyup="setAmountValue()">
                                        </div> -->
                                    <!-- </div>
                                    <div class="row mt-2"> -->
                                        <div class="col-sm-5 mt-2">
                                            <label>UPI QR CODE (512 * 512 )</label>
										        <input type="file" name="upi_qr_code" id="upi_qr_code" class="form-control" >
                                        </div>
                                        <div class="col-sm-1" style="margin-top: 40px">
                                            <a href="<?php echo $row["upi_qr_code"] ?>" target="_blank">
                                                <img style="width: 40px;height:40px" src="<?php echo $row["upi_qr_code"] ?>">
                                            </a>
                                        </div>
                                        <div class="col-sm-6 mt-2">
                                            <label>Service not available content</label>
                                            <input type="text" name="service_not_available_content" id="service_not_available_content" class="form-control" placeholder="Service not available content" value="<?php echo $row['service_not_available_content'] ?>">
                                        </div>
                                        <div class="col-sm-6 mt-2">
                                            <label>Customer Care Number</label>
                                            <input type="text" name="customer_care_no" id="customer_care_no" class="form-control" placeholder="Customer Care Number" value="<?php echo $row['customer_care_no'] ?>">
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
            let percent = document.getElementById('percentage_to_client')
            let amount = document.getElementById('amount_to_client')

            if(percent.value){
                amount.value = 0
            }
        }
        function setAmountValue() {
            let percent = document.getElementById('percentage_to_client')
            let amount = document.getElementById('amount_to_client')

            if(amount.value){
                percent.value = 0
            }
        }
    </script>
</body>
</html>