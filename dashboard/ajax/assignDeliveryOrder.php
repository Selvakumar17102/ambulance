<?php
    include('../include/connection.php');
    include('../../api/fcm.php');

    if(isset($_POST['order_id'])){
        $order_id = $_POST['order_id'];

        $sql = "SELECT * FROM orders WHERE order_id='$order_id' AND delivery_partner_id!='0'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            echo 'true';
        } else{
            echo 'false';
        }
    }
?>