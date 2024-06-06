<?php
    ini_set('display_errors','on');
    include('include/connection.php');
    include("../api/password.php");
    $menu = 'active';
    $menuShow = 'show';
    $menuBoolean = 'true';
    $branch = 'active';

    if(isset($_POST['add'])){
        $name = $_POST['name'];

        $image = $_FILES['image']['name'];
        $username = $_POST['username'];
        $phone = $_POST['phone'];
        $whatsapp = $_POST['whatsapp'];
        $password = $_POST['password'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $address = $_POST['address'];
        $intime = $_POST['intime'];

        $razorpay_merchant_id = $_POST['razorpay_merchant_id'];
        $razorpay_merchant_key = $_POST['razorpay_merchant_key'];
        
        $outtime = $_POST['outtime'];
        // $gst = $_POST['gst'];
        $packing_charge = $_POST['packing_charge'];
        $peak_charge = $_POST['peak_charge'];

        if(!$peak_charge) $peak_charge = 0;
        
        $passwordResponce = json_decode(generatePass($conn,$password));

        $NewPass = $passwordResponce->password;
        $cipher = $passwordResponce->cipher;

        $sql = "INSERT INTO login (username,password,cipher,login_phone_number,control) VALUES ('$username','$NewPass','$cipher','$phone','1')";
        if($conn->query($sql) === TRUE){
            $sql = "SELECT * FROM login ORDER BY login_id DESC LIMIT 1";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            $login_id = $row['login_id'];

            $sql = "INSERT INTO branch (login_id,branch_name,branch_address,branch_latitude,branch_longitude,branch_intime,branch_outtime,branch_phone,branch_whatsapp,razorpay_merchant_id,razorpay_merchant_key) 
            VALUES ('$login_id','$name','$address','$latitude','$longitude','$intime','$outtime','$phone','$whatsapp','$razorpay_merchant_id','$razorpay_merchant_key')";
            if($conn->query($sql) === TRUE){

                $sql = "SELECT * FROM branch ORDER BY branch_id DESC LIMIT 1";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $branch_id = $row['branch_id'];

                if($image){
                    $type=pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
                    $randomid = mt_rand(10,999999);
                    $path="Images/Category/$randomid$branch_id.$type";
                    $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG');
                    if(in_array($type, $allowTypes)){
                        if(move_uploaded_file($_FILES["image"]["tmp_name"], $path)){
                            $sql2 = "UPDATE branch SET branch_image = '$path' WHERE branch_id='$branch_id'";
                            $conn->query($sql2);
                            header('Location: branch.php?msg=City added!');
                        } 
                    }
                }
                header('Location: branch.php?msg=City added!');
            } else{
                $sql1 = "DELETE FROM login WHERE login_id='$login_id'";
                if($conn->query($sql1) === TRUE){
                    header("Location: branch.php?err=$sql!");
                }
            }
        } else{
            header("Location: branch.php?err=$sql");
        }
    }

    if(isset($_POST['edit'])){
        $login_id = $_POST['login_id'];
        $name = $_POST['name'];
        $image = $_FILES['image']['name'];
        $phone = $_POST['phone'];
        $whatsapp = $_POST['whatsapp'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $address = $_POST['address'];
        $intime = $_POST['intime'];
        $outtime = $_POST['outtime'];
        // $gst = $_POST['gst'];
        // $packing_charge = $_POST['packing_charge'];
        // $peak_charge = $_POST['peak_charge'];

        $razorpay_merchant_id = $_POST['razorpay_merchant_id'];
        $razorpay_merchant_key = $_POST['razorpay_merchant_key'];

        $sql = "UPDATE login SET login_phone_number='$phone' WHERE login_id='$login_id'";
        if($conn->query($sql) === TRUE){
            $sql = "UPDATE branch SET razorpay_merchant_id='$razorpay_merchant_id',razorpay_merchant_key='$razorpay_merchant_key',branch_name='$name',branch_address='$address',branch_latitude='$latitude',branch_longitude='$longitude',branch_intime='$intime',branch_outtime='$outtime',branch_phone='$phone',branch_whatsapp='$whatsapp' WHERE login_id='$login_id'";
            if($conn->query($sql) === TRUE){

                $sql = "SELECT * FROM branch WHERE login_id='$login_id'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $branch_id = $row['branch_id'];

                if(is_file($row['branch_image'])){
                    $brancyImages = $row['branch_image'];
                }else{
                    $brancyImages='';
                }

                if($image){
                    $type=pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
                    $randomid = mt_rand(10,999999);
                    $path="Images/Category/$randomid$branch_id.$type";
                    $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG');
                    if(in_array($type, $allowTypes)){
                        if(move_uploaded_file($_FILES["image"]["tmp_name"], $path)){
                            unlink($brancyImages);
                            $sql2 = "UPDATE branch SET branch_image = '$path' WHERE branch_id='$branch_id'";
                            $conn->query($sql2);
                        } 
                    }
                }

                header('Location: branch.php?msg=City updated!');
            } else{
                header('Location: branch.php?err=City updation failed!');
            }
        } else{
            header('Location: branch.php?err=City updationjjj failed!');
        }
    }

    if(isset($_POST['delete'])){
        $login_id = $_POST['login_id'];
        
        $sql = "SELECT * FROM branch WHERE login_id='$login_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if(is_file($row['branch_image'])){
            $brancyImages = $row['branch_image'];
        }else{
            $brancyImages='';
        }
        $sql = "DELETE FROM login WHERE login_id='$login_id'";
        if($conn->query($sql) === TRUE){
            $sql = "DELETE FROM branch WHERE login_id='$login_id'";
            if($conn->query($sql) === TRUE){
                unlink($brancyImages);
                header('Location: branch.php?msg=City deleted!');
            }
        }
    }

    if(isset($_POST['change'])){
        $password = $_POST['password'];
        $login_id = $_POST['login_id'];

        $passwordResponce = json_decode(generatePass($conn,$password));

        $NewPass = $passwordResponce->password;
        $cipher = $passwordResponce->cipher;

        $sql = "UPDATE login SET password='$NewPass',cipher='$cipher' WHERE login_id='$login_id'";
        if($conn->query($sql) === TRUE){
            header('Location: branch.php?msg=City password changed!');
        } else{
            header('Location: branch.php?err=Change password failed!');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>City | Salvo Ambulance</title>
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
                                        <h4>All City</h4>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="button" class="btn btn-outline-secondary float-right m-3" data-toggle="modal" data-target="#exampleModal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                            Add New
                                        </button>
                                        <div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="padding-right: 17px; display: none;" aria-modal="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <form method="post" enctype="multipart/form-data">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addAdminTitle">Add branch</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                <label>City Name</label>
                                                                    <input type="text" name="name" id="name" class="form-control" placeholder="City Name" autocomplete="off">
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label>City Image (512 * 512)</label>
																	<input type="file" name="image" id="image" class="form-control">

                                                                    <!-- <input type="text" name="image" id="image" placeholder="City Image" autocomplete="off" class="form-control"> -->
                                                                </div>
                                                            </div>
                                                            <div class="row mt-1">
                                                                <div class="col-sm-6">
                                                                <label>User Name</label>
                                                                    <input type="text" name="username" id="username" class="form-control" placeholder="User Name" autocomplete="off" onkeyup="userNameCheck(this.value)" onpaste="userNameCheck(this.value)">
                                                                    <label id="usernameCheck"></label>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label>Phone Number</label>
                                                                    <input type="number" min="0" name="phone" id="phone" placeholder="Phone Number" autocomplete="off" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="row mt-1">
                                                                <div class="col-sm-6">
                                                                <label>Password</label>
                                                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off">
                                                                    <label id="passWordCheck"></label>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                <label>Retype Password</label>
                                                                    <input type="password" name="retype_password" id="retype_password" placeholder="Retype Password" autocomplete="off" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="row mt-1">
                                                                <div class="col-sm-6">
                                                                <label>Razorpay Merchent ID</label>
                                                                    <input type="text" name="razorpay_merchant_id" id="razorpay_merchant_id" class="form-control" placeholder="Razorpay Merchent ID" autocomplete="off">
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label>Razorpay Merchent Key</label>
                                                                    <input type="text" name="razorpay_merchant_key" id="razorpay_merchant_key" placeholder="Razorpay Merchent Key" autocomplete="off" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="row mt-1">
                                                                <div class="col-sm-6">
                                                                <label>Latitude</label>
                                                                    <input type="text" name="latitude" id="latitude" class="form-control" placeholder="City Latitude" autocomplete="off">
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label>Longitude</label>
                                                                    <input type="text" name="longitude" id="longitude" placeholder="City Longitude" autocomplete="off" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="row mt-1">
                                                                <div class="col-sm-6">
                                                                <label>Brach Opening Time</label>
                                                                    <input type="time" name="intime" id="intime" class="form-control" autocomplete="off" value="08:00">
                                                                   
                                                                </div>
                                                                <div class="col-sm-6">
                                                                <label>Brach Closing Time</label>

                                                                    <input type="time" name="outtime" id="outtime" autocomplete="off" class="form-control" value="22:00">
                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="row mt-1">
                                                                <div class="col-sm-6">
                                                                <label>Whatsapp Number</label>

                                                                    <input type="number" min="0" name="whatsapp" id="whatsapp" placeholder="WhatsApp Number" autocomplete="off" class="form-control">
                                                                   
                                                                </div>
                                                                <!-- <div class="col-sm-6">
                                                                    <label>Packing Charge</label>
                                                                    <input type="number" min="0" name="packing_charge" id="packing_charge" placeholder="Packing Charge" autocomplete="off" class="form-control">
                                                                   
                                                                </div> -->
                                                            </div>
                                                            <div class="row mt-1">
                                                                <!-- <div class="col-sm-12">
                                                                <label>Peak Charge</label>
                                                                    <input type="number" min="0" name="peak_charge" id="peak_charge" placeholder="Peak Charge" autocomplete="off" class="form-control">
                                                                   
                                                                </div> -->
                                                                <!-- <div class="col-sm-6">
                                                                    <input type="text" name="gst" id="gst" placeholder="GST No" class="form-control">
                                                                   
                                                                </div> -->
                                                            </div>
                                                            <div class="row mt-1">
                                                                <div class="col-sm-12">
                                                                <label>Address</label>
                                                                    <textarea name="address" id="address" class="form-control" placeholder="Address"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                                            <button type="submit" name="add" onclick="return branchAdd()" class="btn btn-primary">Add</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="table-responsive">
                                    <table class="table mb-4 convert-data-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Phone</th>
                                                <th class="text-center">Username</th>
                                                <th class="text-center">Address</th>
                                                <th class="text-center">Timing</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql = "SELECT * FROM branch ORDER BY branch_name ASC";
                                                $result = $conn->query($sql);
                                                $count = 0;
                                                while($row = $result->fetch_assoc())
                                                {
                                                    $login_id = $row['login_id'];

                                                    $status = '';
                                                    if($row['branch_status'] == 1){
                                                        $status = 'checked';
                                                    }

                                                    $sql1 = "SELECT * FROM login WHERE login_id='$login_id'";
                                                    $result1 = $conn->query($sql1);
                                                    $row1 = $result1->fetch_assoc();
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo ++$count ?></td>
                                                    <td class="text-center"><?php echo $row["branch_name"] ?></td>
                                                    <td class="text-center"><img style="height: 150px; width: 150px" src="<?php echo $row["branch_image"] ?>"></td>
                                                    <td class="text-center"><?php echo $row1["login_phone_number"] ?></td>
                                                    <td class="text-center"><?php echo $row1["username"] ?></td>
                                                    <td class="text-center"><?php echo $row["branch_address"] ?></td>
                                                    <td class="text-center"><?php echo date('h:i A', strtotime($row["branch_intime"])).' - '.date('h:i A', strtotime($row['branch_outtime'])) ?></td>
                                                    <td class="text-center">
                                                        <label class="switch s-icons s-outline s-outline-success mr-2" style="margin-bottom: 0px !important">
                                                            <input type="checkbox" id="S<?php echo $login_id ?>" <?php echo $status ?> onclick="return branchStatus(<?php echo $login_id ?>)">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td class="text-center">
                                                        <ul class="table-controls">
                                                            <li>
                                                                <a data-toggle="modal" data-target="#edit<?php echo $count ?>">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                                                </a>
                                                                <div class="modal fade" id="edit<?php echo $count ?>" tabindex="-1" role="dialog" aria-labelledby="addAdminTitle<?php echo $count ?>" style="display: none;" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <form method="post" enctype="multipart/form-data">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="addAdminTitle<?php echo $count ?>">Edit City</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-6">
                                                                                        <label>City Name</label>
                                                                                            <input type="text" name="name" id="name<?php echo $login_id ?>" class="form-control" placeholder="City Name" autocomplete="off" value="<?php echo $row['branch_name'] ?>">
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                        <label>City Image (512 * 512)</label>
                                                                                        <input type="file" name="image" id="image<?php echo $login_id ?>" class="form-control" placeholder="City Image">
                                                                                            <!-- <input type="text" name="image" id="image<?php echo $login_id ?>" placeholder="City Image" autocomplete="off" class="form-control" value="<?php echo $row['branch_image'] ?>"> -->
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row mt-1">
                                                                                        <div class="col-sm-6">
                                                                                        <label>User Name</label>
                                                                                            <input type="text" name="username" id="username<?php echo $login_id ?>" class="form-control" placeholder="User Name" autocomplete="off" disabled value="<?php echo $row1['username'] ?>">
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                        <label>Phone Number</label>

                                                                                            <input type="number" min="0" name="phone" id="phone<?php echo $login_id ?>" placeholder="Phone Number" autocomplete="off" class="form-control" value="<?php echo $row1['login_phone_number'] ?>">
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="row mt-1">
                                                                                        <div class="col-sm-6">
                                                                                        <label>Razorpay Merchent ID</label>
                                                                                            <input type="text" name="razorpay_merchant_id" id="razorpay_merchant_id<?php echo $login_id ?>" class="form-control" placeholder="Razorpay Merchent ID" autocomplete="off" value="<?php echo $row['razorpay_merchant_id'] ?>">
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <label>Razorpay Merchent Key</label>
                                                                                            <input type="text" name="razorpay_merchant_key" id="razorpay_merchant_key<?php echo $login_id ?>" placeholder="Razorpay Merchent Key" autocomplete="off" class="form-control" value="<?php echo $row['razorpay_merchant_key'] ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row mt-1">
                                                                                        <div class="col-sm-6">
                                                                                         <label>Latitude</label>

                                                                                            <input type="text" name="latitude" id="latitude<?php echo $login_id ?>" class="form-control" placeholder="City Latitude" autocomplete="off" value="<?php echo $row['branch_latitude'] ?>">
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                        <label>Longitude</label>

                                                                                            <input type="text" name="longitude" id="longitude<?php echo $login_id ?>" placeholder="City Longitude" autocomplete="off" class="form-control" value="<?php echo $row['branch_longitude'] ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row mt-1">
                                                                                        <div class="col-sm-6">
                                                                                        <label>Brach Opening Time</label>
                                                                                            <input type="time" name="intime" id="intime<?php echo $login_id ?>" class="form-control" autocomplete="off" value="<?php echo $row['branch_intime'] ?>">
                                                                                           
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                        <label>Brach Closing Time</label>
                                                                                            <input type="time" name="outtime" id="outtime<?php echo $login_id ?>" autocomplete="off" class="form-control" value="<?php echo $row['branch_outtime'] ?>">
                                                                                           
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row mt-1">
                                                                                        <div class="col-sm-6">
                                                                                        <label>Whatsapp Number</label>
                                                                                            <input type="number" min="0" name="whatsapp" id="whatsapp<?php echo $login_id ?>" placeholder="WhatsApp Number" autocomplete="off" class="form-control" value="<?php echo $row['branch_whatsapp'] ?>">
                                                                                           
                                                                                        </div>
                                                                                        <!-- <div class="col-sm-6">
                                                                                        <label>Packing Charge</label>
                                                                                            <input type="number" min="0" name="packing_charge" id="packing_charge<?php echo $login_id ?>" placeholder="Packing Charge" autocomplete="off" class="form-control" value="<?php echo $row['packing_charge'] ?>">
                                                                                           
                                                                                        </div> -->
                                                                                    </div>
                                                                                    <div class="row mt-1">
                                                                                        <!-- <div class="col-sm-12">
                                                                                        <label>Peak Charge</label>
                                                                                            <input type="number" min="0" name="peak_charge" id="peak_charge<?php echo $login_id ?>" placeholder="Peak Charge" autocomplete="off" class="form-control"value="<?php echo $row['peak_charge'] ?>">
                                                                                           
                                                                                        </div> -->
                                                                                        <!-- <div class="col-sm-12">
                                                                                            <input type="text" name="gst" id="gst" placeholder="GST No" class="form-control" value="<?php echo $row['gst'] ?>">
                                                                                           
                                                                                        </div> -->
                                                                                    </div>
                                                                                    <div class="row mt-1">
                                                                                        <div class="col-sm-12">
                                                                                        <label>Address</label>
                                                                                            <textarea name="address" id="address<?php echo $login_id ?>" class="form-control" placeholder="Address"><?php echo $row['branch_address'] ?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <input type="hidden" name="login_id" value="<?php echo $login_id ?>">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                                                                    <button type="submit" name="edit" onclick="return branchEdit(<?php echo $login_id ?>)" class="btn btn-primary">Save</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <a data-toggle="modal" data-target="#deleteAdmin<?php echo $count ?>">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                                                </a>
                                                                <div class="modal fade" id="deleteAdmin<?php echo $count ?>" tabindex="-1" role="dialog" aria-labelledby="addAdminTitle" style="display: none;" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <form method="post">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="addAdminTitle">Delete City</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p class="modal-text">Are you sure to delete this branch <b><?php echo $row['branch_name'] ?></b>!</p>
                                                                                    <input type="hidden" name="login_id" value="<?php echo $login_id ?>">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button class="btn" data-dismiss="modal"> No</button>
                                                                                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <a data-toggle="modal" data-target="#change<?php echo $count ?>">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                                                </a>
                                                                <div class="modal fade" id="change<?php echo $count ?>" tabindex="-1" role="dialog" aria-labelledby="changeTitle<?php echo $count ?>" style="display: none;" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <form method="post" enctype="multipart/form-data">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="changeTitle<?php echo $count ?>">Change Password</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-6">
                                                                                            <input type="password" name="password" id="password<?php echo $login_id ?>" class="form-control" placeholder="New Password" autocomplete="off">
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <input type="password" name="retypePassword" id="retypePassword<?php echo $login_id ?>" placeholder="Retype Password" autocomplete="off" class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                    <input type="hidden" name="login_id" value="<?php echo $login_id ?>">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                                                                    <button type="submit" name="change" onclick="return branchChangePassword(<?php echo $login_id ?>)" class="btn btn-primary">Save</button>
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