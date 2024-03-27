<?php
    include("import.php");
    $output_array = array();

    $sql = "SELECT * FROM app_control";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $output_array['qr_link'] = $IMAGE_BASE_URL.$row['upi_qr_code'];

        $output_array['status'] = true;
        $output_array['message'] = 'Success';
    }

    echo json_encode($output_array);
?>