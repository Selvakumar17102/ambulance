<?php
    include('../include/connection.php');
    
    if(!empty($_POST['user_id'])){
        $user_id = $_POST['user_id'];
        $status = 1;

        $sql = "SELECT * FROM user WHERE user_id='$user_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if($row['user_status'] == 1){
            $status = 0;
        }

        $sql = "UPDATE user SET user_status='$status' WHERE user_id='$user_id'";
        if($conn->query($sql) === TRUE){
            echo 'true';
        }
    }
?>