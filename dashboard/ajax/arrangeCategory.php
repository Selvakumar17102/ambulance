<?php
    include('../include/connection.php');
    
    if(!empty($_POST['category_id'])){
        $category_id = $_POST['category_id'];
        $value = $_POST['value'] + 1;

        $sql = "UPDATE category SET category_arrangement='$value' WHERE category_id='$category_id'";
        if($conn->query($sql) === TRUE){
            echo 'true';
        }
    }
?>