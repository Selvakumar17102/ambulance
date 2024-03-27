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

    $nonemgselect = $emgselect = $bothselect = '';

    if($row['emergency'] == 0){
        $nonemgselect = 'selected';
    } else if($row['emergency'] == 1){
        $emgselect = 'selected';
    } else if($row['emergency'] == 2){
        $bothselect = 'selected';
    }

    if(isset($_POST['update'])){
        $delivery_partner_name = $_POST['delivery_partner_name'];
        $delivery_partner_email = $_POST['delivery_partner_email'];
        $delivery_partner_date_of_birth = $_POST['delivery_partner_date_of_birth'];
        $delivery_partner_address = mysqli_real_escape_string($conn, $_POST['delivery_partner_address']);
        $delivery_partner_gender = $_POST['delivery_partner_gender'];
        $delivery_partner_phone = $_POST['delivery_partner_phone'];
        $delivery_partner_alternate_mobile = $_POST['delivery_partner_alternate_mobile'];
        $delivery_partner_branch_id = $_POST['delivery_partner_branch_id'];
        $vehicle_type = $_POST['vehicle_type'];
        $delivery_partner_blood_group = $_POST['delivery_partner_blood_group'];
        $delivery_partner_vehicle_name = $_POST['delivery_partner_vehicle_name'];
        $delivery_partner_vehicle_number = $_POST['delivery_partner_vehicle_number'];
        $license_number = $_POST['license_number'];
        $aadhaar_number = $_POST['aadhaar_number'];
        $emergency = $_POST['emergency'];
        $hospital_name = $_POST['hospital_name'];
        $local_charge = $_POST['local_charge'];
        $local_min_distance = $_POST['local_min_distance'];
        $local_extra_charge_per_km = $_POST['local_extra_charge_per_km'];
        $long_charge = $_POST['long_charge'];
        $long_min_distance = $_POST['long_min_distance'];
        $long_max_distance = $_POST['long_max_distance'];
        $long_extra_charge_per_km = $_POST['long_extra_charge_per_km'];

        $sql = "UPDATE delivery_partner SET delivery_partner_name='$delivery_partner_name',delivery_partner_email='$delivery_partner_email',delivery_partner_date_of_birth='$delivery_partner_date_of_birth',delivery_partner_address='$delivery_partner_address',delivery_partner_phone='$delivery_partner_phone',delivery_partner_alternate_mobile='$delivery_partner_alternate_mobile',delivery_partner_branch_id='$delivery_partner_branch_id',vehicle_type='$vehicle_type',delivery_partner_blood_group='$delivery_partner_blood_group',delivery_partner_vehicle_name='$delivery_partner_vehicle_name',delivery_partner_vehicle_number='$delivery_partner_vehicle_number',delivery_partner_gender='$delivery_partner_gender',license_number='$license_number',aadhaar_number='$aadhaar_number',emergency='$emergency',hospital_name='$hospital_name',local_charge='$local_charge',local_min_distance='$local_min_distance',local_extra_charge_per_km='$local_extra_charge_per_km',long_charge='$long_charge',long_min_distance='$long_min_distance',long_max_distance='$long_max_distance',long_extra_charge_per_km='$long_extra_charge_per_km' WHERE delivery_partner_id='$id'";
        if($conn->query($sql) === TRUE){
            $upload_dir = 'uploads'.DIRECTORY_SEPARATOR;
            $allowed_types = array('jpg','JPG','png','PNG','jpeg','JPEG');

            if(!empty(array_filter($_FILES['license']['name']))) {

                $sql3 = "DELETE FROM driver_image_file WHERE driver_id = $id AND type = 1";
                $conn->query($sql3);

                for($i=0; $i < count($_FILES['license']['tmp_name']);$i++) {

                    $file_tmpname = $_FILES['license']['tmp_name'][$i];
                    $file_name = $_FILES['license']['name'][$i];
                    $file_size = $_FILES['license']['size'][$i];
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                    $fName = $id."_".$i;

                    $upload_dir = "Images/License/$fName.$file_ext";

                    if(in_array(strtolower($file_ext), $allowed_types)) {

                        $filepath = $upload_dir;

                        if( move_uploaded_file($file_tmpname, $filepath)) {
                            $sql3 = "INSERT INTO driver_image_file (driver_id,image,type) VALUES ('$id','$filepath','1')";
                            $conn->query($sql3);
                        } else {					
                            echo "Error uploading {$file_name} <br />";
                        }
                    } else {
                        // If file extension not valid
                        echo "Error uploading {$file_name} ";
                        echo "({$file_ext} file type is not allowed)<br / >";
                    }
                }
            }

            if(!empty(array_filter($_FILES['rc_book']['name']))) {

                $sql3 = "DELETE FROM driver_image_file WHERE driver_id = $id AND type = 2";
                $conn->query($sql3);

                for($i=0; $i < count($_FILES['rc_book']['tmp_name']);$i++) {

                    $file_tmpname = $_FILES['rc_book']['tmp_name'][$i];
                    $file_name = $_FILES['rc_book']['name'][$i];
                    $file_size = $_FILES['rc_book']['size'][$i];
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                    $fName = $id."_".$i;

                    $upload_dir = "Images/RC_Book/$fName.$file_ext";

                    if(in_array(strtolower($file_ext), $allowed_types)) {

                        $filepath = $upload_dir;

                        if( move_uploaded_file($file_tmpname, $filepath)) {
                            $sql3 = "INSERT INTO driver_image_file (driver_id,image,type) VALUES ('$id','$filepath','2')";
                            $conn->query($sql3);
                        } else {					
                            echo "Error uploading {$file_name} <br />";
                        }
                    } else {
                        // If file extension not valid
                        echo "Error uploading {$file_name} ";
                        echo "({$file_ext} file type is not allowed)<br / >";
                    }
                }
            }

            if(!empty(array_filter($_FILES['vehicle_image']['name']))) {

                $sql3 = "DELETE FROM driver_image_file WHERE driver_id = $id AND type = 3";
                $conn->query($sql3);

                for($i=0; $i < count($_FILES['vehicle_image']['tmp_name']);$i++) {

                    $file_tmpname = $_FILES['vehicle_image']['tmp_name'][$i];
                    $file_name = $_FILES['vehicle_image']['name'][$i];
                    $file_size = $_FILES['vehicle_image']['size'][$i];
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                    $fName = $id."_".$i;

                    $upload_dir = "Images/Vehicle_Image/$fName.$file_ext";

                    if(in_array(strtolower($file_ext), $allowed_types)) {

                        $filepath = $upload_dir;

                        if( move_uploaded_file($file_tmpname, $filepath)) {
                            $sql3 = "INSERT INTO driver_image_file (driver_id,image,type) VALUES ('$id','$filepath','3')";
                            $conn->query($sql3);
                        } else {					
                            echo "Error uploading {$file_name} <br />";
                        }
                    } else {
                        // If file extension not valid
                        echo "Error uploading {$file_name} ";
                        echo "({$file_ext} file type is not allowed)<br / >";
                    }
                }
            }

            if(!empty(array_filter($_FILES['aadhaar']['name']))) {

                $sql3 = "DELETE FROM driver_image_file WHERE driver_id = $id AND type = 4";
                $conn->query($sql3);

                for($i=0; $i < count($_FILES['aadhaar']['tmp_name']);$i++) {

                    $file_tmpname = $_FILES['aadhaar']['tmp_name'][$i];
                    $file_name = $_FILES['aadhaar']['name'][$i];
                    $file_size = $_FILES['aadhaar']['size'][$i];
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                    $fName = $id."_".$i;

                    $upload_dir = "Images/Aadhaar/$fName.$file_ext";

                    if(in_array(strtolower($file_ext), $allowed_types)) {

                        $filepath = $upload_dir;

                        if( move_uploaded_file($file_tmpname, $filepath)) {
                            $sql3 = "INSERT INTO driver_image_file (driver_id,image,type) VALUES ('$id','$filepath','4')";
                            $conn->query($sql3);
                        } else {					
                            echo "Error uploading {$file_name} <br />";
                        }
                    } else {
                        // If file extension not valid
                        echo "Error uploading {$file_name} ";
                        echo "({$file_ext} file type is not allowed)<br / >";
                    }
                }
            }

            if(!empty($_FILES['delivery_partner_image']['name'])){
                $type=pathinfo($_FILES['delivery_partner_image']['name'],PATHINFO_EXTENSION);
                $path="Images/Delivery/$id.$type";

                $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG');
                if(in_array($type, $allowTypes)){
                    if(move_uploaded_file($_FILES["delivery_partner_image"]["tmp_name"], $path)){
                        $sql2 = "UPDATE delivery_partner SET delivery_partner_image = '$path' WHERE delivery_partner_id='$id'";
                        $conn->query($sql2);
                    } 
                }
            }
            header('Location: ambulanceDriver.php?msg=Updated!');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Edit Driver | Salvo Ambulance</title>
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
                                        <h4>Edit Driver</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Name</label>
                                            <input type="text" name="delivery_partner_name" id="delivery_partner_name" class="form-control" placeholder="Name" autocomplete="off" value="<?php echo $row['delivery_partner_name'] ?>">
                                        </div>
                                        <div class="col-sm-5">
                                            <label>Profile Image</label>
                                            <input type="file" name="delivery_partner_image" id="delivery_partner_image" class="form-control">
                                        </div>
                                        <div class="col-sm-1 mt-4">
                                            <img style="height: 50px;width:50px;" src="<?php echo $row['delivery_partner_image'] ?>" alt="Profile">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Email</label>
                                            <input type="email" name="delivery_partner_email" id="delivery_partner_email" class="form-control" placeholder="Name" autocomplete="off" value="<?php echo $row['delivery_partner_email'] ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Date Of Birth</label>
                                            <input type="date" name="delivery_partner_date_of_birth" id="delivery_partner_date_of_birth" class="form-control" placeholder="Date Of Birth" autocomplete="off" value="<?php echo $row['delivery_partner_date_of_birth'] ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Address</label>
                                            <input type="text" name="delivery_partner_address" id="delivery_partner_address" class="form-control" placeholder="Address" autocomplete="off" value="<?php echo $row['delivery_partner_address'] ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Mobile Number</label>
                                            <input type="text" name="delivery_partner_phone" id="delivery_partner_phone" class="form-control" placeholder="Mobile Number" autocomplete="off" value="<?php echo $row['delivery_partner_phone'] ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Alt Mobile Number</label>
                                            <input type="text" name="delivery_partner_alternate_mobile" id="delivery_partner_alternate_mobile" class="form-control" placeholder="Alt Mobile Number" autocomplete="off" value="<?php echo $row['delivery_partner_alternate_mobile'] ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>City</label>
                                            <select name="delivery_partner_branch_id" id="delivery_partner_branch_id" class="form-control">
                                                <option selected value disabled>Select City</option>
                                                <?php
                                                    $sql1 = "SELECT * FROM branch ORDER BY branch_name ASC";
                                                    $result1 = $conn->query($sql1);
                                                    while($row1 = $result1->fetch_assoc()){
                                                        $s = '';
                                                        if($row['delivery_partner_branch_id'] == $row1['login_id']){
                                                            $s = 'selected';
                                                        }
                                                ?>
                                                        <option <?php echo $s ?> value="<?php echo $row1['login_id'] ?>"><?php echo $row1['branch_name'] ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Vehicle Type</label>
                                            <select name="vehicle_type" id="vehicle_type" class="form-control">
                                                <option selected value disabled>Select Vehicle Type</option>
                                                <?php
                                                    $sql1 = "SELECT * FROM category ORDER BY category_name ASC";
                                                    $result1 = $conn->query($sql1);
                                                    while($row1 = $result1->fetch_assoc()){
                                                        $vs = '';
                                                        if($row['vehicle_type'] == $row1['category_id']){
                                                            $vs = 'selected';
                                                        }
                                                ?>
                                                        <option <?php echo $vs ?> value="<?php echo $row1['category_id'] ?>"><?php echo $row1['category_name'] ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Gender</label>
                                            <select name="delivery_partner_gender" id="delivery_partner_gender" class="form-control">
                                                <option selected value disabled>Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Blood Group</label>
                                            <input type="text" name="delivery_partner_blood_group" id="delivery_partner_blood_group" class="form-control" placeholder="Blood Group" autocomplete="off" value="<?php echo $row['delivery_partner_blood_group'] ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Vehicle Name</label>
                                            <input type="text" name="delivery_partner_vehicle_name" id="delivery_partner_vehicle_name" class="form-control" placeholder="Vehicle Name" autocomplete="off" value="<?php echo $row['delivery_partner_vehicle_name'] ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Vehicle Number</label>
                                            <input type="text" name="delivery_partner_vehicle_number" id="delivery_partner_vehicle_number" class="form-control" placeholder="Vehicle Number" autocomplete="off" value="<?php echo $row['delivery_partner_vehicle_number'] ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>License Number</label>
                                            <input type="text" name="license_number" id="license_number" class="form-control" placeholder="License Number" autocomplete="off" value="<?php echo $row['license_number'] ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Aadhaar Number</label>
                                            <input type="text" name="aadhaar_number" id="aadhaar_number" class="form-control" placeholder="Aadhaar Number" autocomplete="off" value="<?php echo $row['aadhaar_number'] ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Emergency Acceptable</label>
                                            <select class="form-control" name="emergency" id="emergency">
                                                <option selected value disabled>Select emergency acceptance</option>
                                                <option <?php echo $nonemgselect ?> value="0">Non-Emergency</option>
                                                <option <?php echo $emgselect ?> value="1">Emergency</option>
                                                <option <?php echo $bothselect ?> value="2">Both</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <label>Hospital Name</label>
                                            <input type="text" name="hospital_name" id="hospital_name" class="form-control" placeholder="Hospital Name" autocomplete="off" value="<?php echo $row['hospital_name'] ?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Local Charge</label>
                                            <input type="number" name="local_charge" id="local_charge" class="form-control" placeholder="Local Charge" autocomplete="off" value="<?php echo $row['local_charge'] ?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Local Min Distance</label>
                                            <input type="number" name="local_min_distance" id="local_min_distance" class="form-control" placeholder="Local Min Distance" autocomplete="off" value="<?php echo $row['local_min_distance'] ?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Local Extra Charge Per Km</label>
                                            <input type="number" name="local_extra_charge_per_km" id="local_extra_charge_per_km" class="form-control" placeholder="Local Extra Charge Per Km" autocomplete="off" value="<?php echo $row['local_extra_charge_per_km'] ?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Long Min Distance</label>
                                            <input type="number" name="long_min_distance" id="long_min_distance" class="form-control" placeholder="Long Min Distance" autocomplete="off" value="<?php echo $row['long_min_distance'] ?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Long Charge</label>
                                            <input type="number" name="long_charge" id="long_charge" class="form-control" placeholder="Long Charge" autocomplete="off" value="<?php echo $row['long_charge'] ?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Long Max Distance</label>
                                            <input type="number" name="long_max_distance" id="long_max_distance" class="form-control" placeholder="Long Min Distance" autocomplete="off" value="<?php echo $row['long_max_distance'] ?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Long Extra Charge Per Km</label>
                                            <input type="number" name="long_extra_charge_per_km" id="long_extra_charge_per_km" class="form-control" placeholder="Long Extra Charge Per Km" autocomplete="off" value="<?php echo $row['long_extra_charge_per_km'] ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>License (jpg, jpeg, png)</label>
                                            <input type="file" name="license[]" id="license" class="form-control" placeholder="License (jpg, jpeg, png)" autocomplete="off" multiple>
                                        </div>
                                        <div class="col-sm-6 mt-4">
                                            <?php
                                                $sql5 = "SELECT * FROM driver_image_file WHERE driver_id = '$id' AND image!='' AND type=1";
                                                $result5 = $conn->query($sql5);
                                                while($driverImageTable = $result5->fetch_assoc()){
                                            ?>
                                                    <img style="height: 50px;width:50px;" src="<?php echo $driverImageTable['image'] ?>" alt="License Images">
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>RC Book (jpg, jpeg, png)</label>
                                            <input type="file" name="rc_book[]" id="rc_book" class="form-control" placeholder="RC Book (jpg, jpeg, png)" autocomplete="off" multiple>
                                        </div>
                                        <div class="col-sm-6 mt-4">
                                            <?php
                                                $sql5 = "SELECT * FROM driver_image_file WHERE driver_id = '$id' AND image!='' AND type=2";
                                                $result5 = $conn->query($sql5);
                                                while($driverImageTable = $result5->fetch_assoc()){
                                            ?>
                                                    <img style="height: 50px;width:50px;" src="<?php echo $driverImageTable['image'] ?>" alt="RC Book Images">
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Vehicle Image (jpg, JPG, jpeg, JPEG, png, PNG)</label>
                                            <input type="file" name="vehicle_image[]" id="vehicle_image" class="form-control" placeholder="Vehicle Image (jpg, jpeg, png)" autocomplete="off" multiple>
                                        </div>
                                        <div class="col-sm-6 mt-4">
                                            <?php
                                                $sql5 = "SELECT * FROM driver_image_file WHERE driver_id = '$id' AND image!='' AND type=3";
                                                $result5 = $conn->query($sql5);
                                                while($driverImageTable = $result5->fetch_assoc()){
                                            ?>
                                                    <img style="height: 50px;width:50px;" src="<?php echo $driverImageTable['image'] ?>" alt="Vehicle Images">
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Aadhaar (jpg, JPG, jpeg, JPEG, png, PNG)</label>
                                            <input type="file" name="aadhaar[]" id="aadhaar" class="form-control" placeholder="Aadhaar (jpg, jpeg, png)" autocomplete="off" multiple>
                                        </div>
                                        <div class="col-sm-6 mt-4">
                                            <?php
                                                $sql5 = "SELECT * FROM driver_image_file WHERE driver_id = '$id' AND image!='' AND type=4";
                                                $result5 = $conn->query($sql5);
                                                while($driverImageTable = $result5->fetch_assoc()){
                                            ?>
                                                    <img style="height: 50px;width:50px;" src="<?php echo $driverImageTable['image'] ?>" alt="Aadhaar">
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <input type="submit" name="update" value="Update" class="float-right btn btn-primary">
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