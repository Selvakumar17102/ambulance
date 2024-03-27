<?php
    include('../include/connection.php');
    
    if(!empty($_POST['delivery_partner_id'])){
        $delivery_partner_id = $_POST['delivery_partner_id'];
        $status = 0;

        $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if($row['delivery_partner_status'] == 0){
            $status = 1;
        }

        $sql = "UPDATE delivery_partner SET delivery_partner_status='$status' WHERE delivery_partner_id='$delivery_partner_id'";
        if($conn->query($sql) === TRUE){
            echo 'true';
        }
    }
?>