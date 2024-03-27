<?php
    include('../include/connection.php');
    
    if(!empty($_POST['service_type_id'])){
        $service_type_id = $_POST['service_type_id'];
        $status = 0;

        $sql = "SELECT * FROM service_type WHERE service_type_id='$service_type_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if($row['service_type_status'] == 0){
            $status = 1;
        }

        $sql = "UPDATE service_type SET service_type_status='$status' WHERE service_type_id='$service_type_id'";
        if($conn->query($sql) === TRUE){
            echo 'true';
        }
    }
?>