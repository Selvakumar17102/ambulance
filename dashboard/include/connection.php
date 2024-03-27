<?php
    ini_set('display_errors', 'off');

    $host = "localhost";
    $username = "root";
    $password = "";
    $db_name = "salvo";
    $conn = mysqli_connect("$host", "$username", "$password")or die("cannot connect");
    mysqli_select_db($conn,"$db_name")or die("cannot select DB");

    session_start();

    $login_id = $_SESSION['login_id'];

    $sql = "SELECT * FROM login WHERE login_id='$login_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $control = $row['control'];

    $name = '';
    if($control == 1){
        $sql = "SELECT * FROM branch WHERE login_id='$login_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $branch_status = $row['branch_status'];
        $name = ucfirst($row['branch_name']);
    } else{
        $name = 'Admin';
    }
?>