<?php
    include('../include/connection.php');
    
    if(!empty($_POST['offer_id'])){
        $offer_id = $_POST['offer_id'];
        $status = 0;

        $sql = "SELECT * FROM offer WHERE offer_id='$offer_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if($row['offer_status'] == 0){
            $status = 1;
        }

        $sql = "UPDATE offer SET offer_status='$status' WHERE offer_id='$offer_id'";
        if($conn->query($sql) === TRUE){
            echo 'true';
        }
    }
?>