<?php
    include('../include/connection.php');
    include('../../api/fcm.php');
    include('../../api/onesignaldelivery.php');
    ini_set('display_errors','off');

    if(isset($_POST['order_id'])){
        $order_id = $_POST['order_id'];
        $delivery_partner_id = $_POST['delivery_partner_id'];

        $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $delivery_partner_name = $row['delivery_partner_name'];

        $title = "Hi ". $delivery_partner_name;
        $message = "Order has been assigned to you";

        $sql2 = "SELECT order_status FROM orders WHERE order_id='$order_id'";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();

        $order_status = $row2['order_status'];

        $res = sendNotificationDelivery($delivery_partner_id,$title, $message,'',$order_id, '3', '');
        $output['res'] = $res;
        
        $sql = "UPDATE orders SET delivery_partner_id='$delivery_partner_id' WHERE order_id='$order_id'";
        if($conn->query($sql) === TRUE){
            $sql = "SELECT * FROM orders WHERE order_id='$order_id'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            $order_string = $row['order_string'];

            $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            $delivery_partner_name = ucfirst($row['delivery_partner_name']);
            $delivery_partner_fcm = $row['delivery_partner_fcm'];
       
            echo $delivery_partner_name.' has been assigned to '.$order_string.'.';
            // echo $res;
            
        }
    }
?>