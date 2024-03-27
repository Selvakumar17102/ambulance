<?php
    include('../include/connection.php');
    
    if(!empty($_POST['banner_id'])){
        $banner_id = $_POST['banner_id'];
        $value = $_POST['value'] + 1;

        $sql = "UPDATE banner SET banner_arrangement='$value' WHERE banner_id='$banner_id'";
        if($conn->query($sql) === TRUE){
            echo 'true';
        }
    }
?>