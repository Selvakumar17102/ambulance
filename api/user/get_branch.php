<?php
    include("import.php");

    $sql = "SELECT * FROM branch WHERE branch_status='1'";
    $result = $conn->query($sql);
    $i = 0; 
    while($row = $result->fetch_assoc()){
        $branchID = $row['login_id'];
        $branchLatitude = $row['branch_latitude'];
        $branchLongitude = $row['branch_longitude'];

        $output_array["GTS"][$i]['branch_id'] = (int)$row['login_id'];
        $output_array["GTS"][$i]['branch_name'] = $row['branch_name'];
        $output_array["GTS"][$i]['mobile_number'] = $row['branch_phone'];
        $output_array["GTS"][$i]['whatsapp'] = '+91'.$row['branch_whatsapp'];
        $output_array["GTS"][$i]['branch_intime'] = date('H:i', strtotime($row['branch_intime']));
        $output_array["GTS"][$i]['branch_outtime'] = date('H:i', strtotime($row['branch_outtime']));                  
        $output_array["GTS"][$i]['branch_address'] = $row['branch_address'];
        $output_array["GTS"][$i]['branch_latitude'] = (float)$row['branch_latitude'];
        $output_array["GTS"][$i]['branch_longitude'] = (float)$row['branch_longitude'];
        $output_array["GTS"][$i]['razorpay_merchant_key'] = $row['razorpay_merchant_key'];

        $i++;

    }
    echo json_encode($output_array);
?>