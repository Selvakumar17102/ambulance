<?php
    session_start();

    unset($_SESSION['login_id']);

    echo 'success';
?>