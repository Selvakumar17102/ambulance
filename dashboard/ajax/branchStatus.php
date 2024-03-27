<?php
    include('../include/connection.php');
    
    if(!empty($_POST['login_id'])){
        $login_id = $_POST['login_id'];
        $status = 0;

        $sql = "SELECT * FROM branch WHERE login_id='$login_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if($row['branch_status'] == 0){
            $status = 1;
        }

        $sql = "UPDATE branch SET branch_status='$status' WHERE login_id='$login_id'";
        if($conn->query($sql) === TRUE){
            echo 'true';
        }
    }
?>