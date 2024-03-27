<?php
    ini_set('display_errors','off');
    date_default_timezone_set("Asia/Kolkata"); 
    include('include/connection.php');
    $date = date("Y-m-d");
    $time = date('H:i:s');

    $status = $_REQUEST['status'];
    $branch_id = $_REQUEST['branch_id'];

    $sql = "UPDATE branch SET branch_status='$status' WHERE login_id='$branch_id'";
    if($conn->query($sql)==TRUE){
        header("Location: dashboard.php?msg=Updated");
    }
?>