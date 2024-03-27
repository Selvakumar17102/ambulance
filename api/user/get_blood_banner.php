<?php
    include("import.php");

    $sql = "SELECT * FROM blood_banner";
    $result = $conn->query($sql);
    $i = 0; 
    while($row = $result->fetch_assoc()){
        $output_array["GTS"][$i]['banner_id'] = (int)$row['id'];
        $output_array["GTS"][$i]['banner_image'] = $IMAGE_BASE_URL.$row['blood_banner_image'];

        $i++;

    }
    echo json_encode($output_array);
?>