<?php
    include('../include/connection.php');
    
    if(!empty($_POST['intro_banner_id'])){
        $intro_banner_id = $_POST['intro_banner_id'];
        $status = 0;

        $sql = "SELECT * FROM intro_banner WHERE intro_banner_id='$intro_banner_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if($row['intro_banner_status'] == 0){
            $status = 1;
        }

        $sql = "UPDATE intro_banner SET intro_banner_status='$status' WHERE intro_banner_id='$intro_banner_id'";
        if($conn->query($sql) === TRUE){
            echo 'true';
        }
    }
?>