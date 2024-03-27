<?php
    ini_set('display_errors','off');
    include('include/connection.php');
    include('../api/fcm.php');

    $report = 'active';
    $reportShow = 'show';
    $reportBoolean = 'true';
    $versionReport = 'active';

    if(isset($_POST['send'])){
        $app_version_id = $_POST['app_version_id'];
        $content = $_POST['content'];

        $sql = "SELECT * FROM app_version WHERE app_version_id='$app_version_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $app_version_name = $row['app_version_name'];

        $sql = "SELECT * FROM user WHERE version='$app_version_name'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            $user_name = $row['user_name'];
            $user_fcm_token = $row['user_fcm_token'];

            $notificationData['title'] = 'Hi '.$user_name;
            $notificationData['body'] = $content;
            $notificationData['type'] = 5;

            $responce = json_decode(sendFcm($conn,$user_fcm_token,$notificationData));
        }

        header("Location: pushNotification.php?Notification Sent!");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Version Report | Salvo Ambulance</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <link href="assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/loader.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />

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
                <?php include('include/notification.php') ?>
                <div class="row layout-top-spacing">
                    <div class="col-sm-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h4>Version Report</h4>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="newVersion.php" target="_blank" class="btn btn-primary float-right" style="margin-top: 5px;display: none">New</a>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-striped mb-4 convert-data-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S.No</th>
                                                <th class="text-center">Version</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Reason</th>
                                                <th class="text-center">User Count</th>
                                                <th class="text-center">Notification</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $count = 1;
                                                $sql = "SELECT * FROM app_version ORDER BY app_version_id DESC";
                                                $result = $conn->query($sql);
                                                while($row = $result->fetch_assoc()){
                                                    $app_version_id = $row['app_version_id'];
                                                    $app_version_name = $row['app_version_name'];

                                                    $sql1 = "SELECT COUNT(*) AS total_user FROM user WHERE version='$app_version_name'";
                                                    $result1 = $conn->query($sql1);
                                                    $row1 = $result1->fetch_assoc();

                                                    $total_user = $row1['total_user'];
                                            ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $count ?></td>
                                                        <td class="text-center"><a style="color: #790c46;font-weight: 600" href="version-user.php?id=<?php echo $row['app_version_id'] ?>"><?php echo $app_version_name ?></a></td>
                                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($row['app_version_date'])) ?></td>
                                                        <td class="text-center"><?php echo $row['app_version_comment'] ?></td>
                                                        <td class="text-center"><?php echo number_format($total_user) ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                                if($count == 1){
                                                                    echo 'Current Version';
                                                                } else{
                                                            ?>
                                                                    <button type="button" onclick="fillUp(<?php echo $app_version_id ?>,'<?php echo $app_version_name ?>')" class="btn btn-primary m-3" data-toggle="modal" data-target="#sendNotification">
                                                                        Send Notification
                                                                    </button>
                                                            <?php
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                    $count++;
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="modal fade show" id="sendNotification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="padding-right: 17px; display: none;" aria-modal="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <form method="post" enctype="multipart/form-data">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="sendNotificationModalTitle">Add Category</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <textarea name="content" id="notificationContent" class="form-control" placeholder="Content" required></textarea>
                                                                <input type="hidden" name="app_version_id" id="app_version_id">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                                        <button type="submit" name="send" class="btn btn-primary">Send</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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