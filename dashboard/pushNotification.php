<?php
    date_default_timezone_set("Asia/Calcutta");
    ini_set('display_errors','on');
    include('include/connection.php');
    include('../api/oneSignalNotification.php');

    $curDate = date('Y-m-d');
    $push = 'active';
    $pushBoolean = 'true';

    
    if($_REQUEST['id'] != ''){
        $notification_id = $_REQUEST['id'];

        $sql = "SELECT * FROM push_notification WHERE notification_id='$notification_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $title= $row['notification_title'];
        $body= $row['notification_body'];
        $type= $row['notification_type'];

        $user_type= $row['user_type'];

        if($row['notification_category_id']){  $category= $row['notification_category_id'];}else{ $category = 0; }
        if($row['notification_url']){  $url= $row['notification_url']; }else{ $url = ''; }
        if($row['notification_image']){  $image= $row['notification_image']; }else{ $image = '';  }
        
        $newdate = date("Y-m-d", strtotime('-1 month', strtotime($curDate)));


        switch($user_type){
            case 1:
                $sql = "SELECT * FROM user";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $user_id = $row['user_id'];
                    $res = oneSignalNotification($user_id,$title,$body,$image,$url,$category,$type);
                }
            break;

            case 2:
                $sql1 = "SELECT * FROM user WHERE user_registration_date BETWEEN '$newdate' AND '$curDate'";
                $result = $conn->query($sql1);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $user_id = $row['user_id'];
                        $res = oneSignalNotification($user_id,$title,$body,$image,$url,$category,$type);
                    }
                }
            break;

            case 3:
                $sql = "SELECT * FROM user WHERE user_registration_date BETWEEN '$newdate' AND '$curDate'";
                $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()){
                        $user_id = $row['user_id'];
                        $sql2 = "SELECT * FROM orders WHERE user_id='$user_id' AND order_status!=0";
                        $result2 = $conn->query($sql2);
                        if($result2->num_rows == 0){
                             $res = oneSignalNotification($user_id,$title,$body,$image,$url,$category,$type);
                        }
                    }
            break;

            case 4:
                $sql = "SELECT * FROM user";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){

                    $user_id = $row['user_id'];
                    $sql2 = "SELECT * FROM orders WHERE user_id='$user_id' AND order_status!=0";
                    $result2 = $conn->query($sql2);
                    if($result2->num_rows == 0){
                        $res = oneSignalNotification($user_id,$title,$body,$image,$url,$category,$type);
                    }
                }
            break;

            case 5:
                $sql = "SELECT user_id, COUNT(*) FROM orders WHERE order_status='5' GROUP BY user_id ORDER BY count(*) DESC LIMIT 100";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $user_id = $row['user_id'];
                    $res = oneSignalNotification($user_id,$title,$body,$image,$url,$category,$type);
                }
            break;
        }
        header("Location: pushNotification.php?Notification Sent!");
    }

    if(isset($_POST['add'])){
        $title = mysqli_real_escape_string($conn,$_POST['title']);
        $image = $_POST['image'];
        $type = $_POST['type'];
        $url = $_POST['url'];
        $category = $_POST['category'];
        $body = mysqli_real_escape_string($conn,$_POST['body']);
        $user_type = $_POST['user_type'];
        
        if(!$user_type){
            $user_type = 1;
        }

        if($category == ''){  $category = 0; }
        if($url == ''){  $url = ''; }
        if($image == ''){ $image = ''; }
        if(!$type){ $type = 3; }

        $sql = "INSERT INTO push_notification (notification_title,notification_body,notification_image,notification_type,notification_url,notification_category_id,user_type) VALUES ('$title','$body','$image','$type','$url','$category','$user_type')";
        if($conn->query($sql) === TRUE){
            $newdate = date("Y-m-d", strtotime('-1 month', strtotime($curDate)));
            switch($user_type){
                case 1:
                    $sql = "SELECT * FROM user";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()){
                        $user_id = $row['user_id'];
                        $res = oneSignalNotification($user_id,$title,$body,$image,$url,$category,$type);
                    }
                break;

                case 2:
                    $sql1 = "SELECT * FROM user WHERE user_registration_date BETWEEN '$newdate' AND '$curDate'";
                    $result = $conn->query($sql1);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $user_id = $row['user_id'];
                            $res = oneSignalNotification($user_id,$title,$body,$image,$url,$category,$type);
                        }
                    }
                break;

                case 3:
                   $sql = "SELECT * FROM user WHERE user_registration_date BETWEEN '$newdate' AND '$curDate'";
                    $result = $conn->query($sql);
                        while($row = $result->fetch_assoc()){
                            $user_id = $row['user_id'];
                            $sql2 = "SELECT * FROM orders WHERE user_id='$user_id' AND order_status!=0";
                            $result2 = $conn->query($sql2);
                            if($result2->num_rows == 0){
                                $res = oneSignalNotification($user_id,$title,$body,$image,$url,$category,$type);
                            }
                        }
                break;

                case 4:
                    $sql = "SELECT * FROM user";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()){
                        $user_id = $row['user_id'];

                        $sql2 = "SELECT * FROM orders WHERE user_id='$user_id' AND order_status!=0";
                        $result2 = $conn->query($sql2);
                        if($result2->num_rows == 0){
                            $res = oneSignalNotification($user_id,$title,$body,$image,$url,$category,$type);
                        }
                    }
                break;

                case 5:
                    $sql = "SELECT user_id, COUNT(*) FROM orders WHERE order_status='5' GROUP BY user_id ORDER BY count(*) DESC LIMIT 100";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()){
                        $user_id = $row['user_id'];
                            $res = oneSignalNotification($user_id,$title,$body,$image,$url,$category,$type);
                        }
                break;
            }
            header("Location: pushNotification.php?Notification Sent!");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Push Notification | Salvo Ambulance</title>
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
        .hide{
            display: none;
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
                                    <div class="col-sm-9">
                                        <h4>All Push Notifications</h4>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="button" class="btn btn-outline-secondary float-right m-3" data-toggle="modal" data-target="#exampleModal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                            Add and Send
                                        </button>
                                        <div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="padding-right: 17px; display: none;" aria-modal="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <form method="post" enctype="multipart/form-data">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addAdminTitle">Add and Send Notification</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" autocomplete="off">
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="text" name="image" id="image" class="form-control" placeholder="Image" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-sm-12">
                                                                    <select name="user_type" id="user_type" class="form-control" >
                                                                        <option selected disabled>Select User Type</option>
                                                                        <option value="1">All Users</option>
                                                                        <option value="2">New Reg. Users</option>
                                                                        <option value="3">New Reg. Users(with zero orders)</option>
                                                                        <option value="4">Users(with zero orders)</option>
                                                                        <option value="5">Top Users</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-sm-12" id="typeClass">
                                                                    <select name="type" id="type" class="form-control" onchange="changeNotificationType(this.value)">
                                                                        <option selected disabled>Select Type</option>
                                                                        <option value="1">News</option>
                                                                        <option value="2">Promotional</option>
                                                                        <option value="3">App</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6 hide" id="categoryClass">
                                                                    <select name="category" id="category" class="form-control">
                                                                        <option selected disabled>Select Category</option>
                                                                        <?php
                                                                            $sql = "SELECT * FROM category WHERE category_status='1' ORDER BY category_name ASC";
                                                                            $result = $conn->query($sql);
                                                                            while($row = $result->fetch_assoc()){
                                                                        ?>
                                                                                <option value="<?php echo $row['category_id'] ?>"><?php echo $row['category_name'] ?></option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6 hide" id='urlClass'>
                                                                    <input type="text" name="url" id="url" class="form-control" placeholder="Ex: https://www.example.com/">
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-sm-12">
                                                                    <textarea name="body" id="body" class="form-control" placeholder="Body" style="resize: none;height: 75px"></textarea>
                                                                </div>
                                                            </div>                                                            
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                                            <button type="submit" name="add" onclick="return notificationAdd()" class="btn btn-primary">Add</button>
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
                                                <th class="text-center">Title</th>
                                                <th class="text-center">Body</th>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Type</th>
                                                <th class="text-center">Category</th>
                                                <th class="text-center">URL</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql = "SELECT * FROM push_notification";
                                                $result = $conn->query($sql);
                                                $count = 0;
                                                while($row = $result->fetch_assoc())
                                                {
                                                    $category = '';
                                                    if($row['notification_type'] == 1){
                                                        $notification_type = 'News';
                                                    } else{
                                                        if($row['notification_type'] == 2){
                                                            $notification_type = 'Promotional';
                                                            $category_id = $row['notification_category_id'];

                                                            $sql1 = "SELECT * FROM category WHERE category_id='$category_id'";
                                                            $result1 = $conn->query($sql1);
                                                            $row1 = $result1->fetch_assoc();

                                                            $category = $row1['category_name'];
                                                        } else{
                                                            $notification_type = 'App';
                                                        }
                                                    }
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo ++$count ?></td>
                                                    <td class="text-center"><?php echo $row["notification_title"] ?></td>
                                                    <td class="text-center"><?php echo $row["notification_body"] ?></td>
                                                    <td class="text-center">
                                                    <?php if($row['notification_image']){ ?>
                                                        <img src="<?php echo $row['notification_image'] ?>" style="width: 150px">
                                                    <?php }else{
                                                        echo "No Image Found"; } ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $notification_type ?></td>
                                                    <td class="text-center"><?php echo $category ?></td>
                                                    <td class="text-center"><?php echo $row['notification_url'] ?></td>
                                                    <td class="text-center">
                                                        <a href="pushNotification.php?id=<?php echo $row['notification_id'] ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                                                        </a>
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