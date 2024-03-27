<?php
    include("import.php");

    $sql = "SELECT * FROM commonbanner";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $i = 0;
        while($row = $result->fetch_assoc()){
            
            $output_array['GTS'][$i]['type'] = $row['type'];
            $output_array['GTS'][$i]['banner_image'] = $IMAGE_BASE_URL.$row['bannerimg'];
            $i++;
        }

        $output_array['status'] = true;
    } else{
        http_response_code(404);
        $output_array['status'] = false;
        $output_array['message'] = "Data not found";
    }

    echo json_encode($output_array);
?>