<?php
    include('../include/connection.php');
    
    if(!empty($_POST['payment_method_id'])){
        $payment_method_id = $_POST['payment_method_id'];
        $status = 0;

        $sql = "SELECT * FROM payment_method WHERE payment_method_id='$payment_method_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if($row['payment_method_status'] == 0){
            $status = 1;
        }

        $sql = "UPDATE payment_method SET payment_method_status='$status' WHERE payment_method_id='$payment_method_id'";
        if($conn->query($sql) === TRUE){
            echo 'true';
        }
    }
?>