<?php
    include('../include/connection.php');
    
    if(!empty($_POST['category'])){
        $cate = $_POST['category'];
        $id = $_POST['category_id'];

        if($id != 0){
            $sql = "SELECT * FROM category WHERE category_name='$cate' AND category_id!='$id'";
        } else{
            $sql = "SELECT * FROM category WHERE category_name='$cate'";
        }
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            echo 'true';
        }
    }
?>