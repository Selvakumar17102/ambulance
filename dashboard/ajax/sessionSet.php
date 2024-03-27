<?php
    session_start();

    if(!isset($_SESSION['login_id'])){
        $_SESSION['login_id'] = $_POST['login'];
        echo 'false';
    } else{
        echo 'true';
    }
?>