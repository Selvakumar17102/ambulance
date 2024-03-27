<?php
    include('../include/connection.php');
    ini_set('display_errors','off');
    
    if(!empty($_POST['username'])){
        $username = $_POST['username'];
        $id = $_POST['login_id'];

        if($id!=0 && $id!=''){
            $sql = "SELECT * FROM login WHERE username='$username' AND login_id!='$id'";
        } else{
            $sql = "SELECT * FROM login WHERE username='$username'";
        }
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            echo 'true';
        } else{
            echo 'false';
        }
    }
?>