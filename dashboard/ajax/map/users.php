<?php
    include('../../include/connection.php');
    
    $days = $count = array();
    $yesterday = date('Y-m-d', strtotime('-1 days'));
    $past_7 = date('Y-m-d', strtotime('-7 days'));
    $i = 0;
    for($date=$past_7;$date<=$yesterday;$date=date('Y-m-d', strtotime($date.'+1 days'))){
        $days[$i] = date('l', strtotime($date));

        $sql = "SELECT * FROM user WHERE user_registration_date='$date'";
        $result = $conn->query($sql);
        $count[$i] = $result->num_rows;
        $i++;
    }

    $out['days'] = $days;
    $out['count'] = $count;

    echo json_encode($out);
?>