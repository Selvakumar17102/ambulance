<?php
    include('include/connection.php');
    include('../api/fcm.php');

    $id = $_REQUEST['id'];
    $cancelled_from = $_REQUEST['cancelled_from'];
    $page = $_REQUEST['page'];

    $sql = "SELECT * FROM orders WHERE order_id='$id'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $sql = "UPDATE orders SET order_status=0,cancelled_by='Cancelld By $name',cancelled_from='$cancelled_from' WHERE order_id='$id'";
        if($conn->query($sql) === TRUE){
            header("Location: $page.php?msg=Order cancelled!");
        }
    }
?>