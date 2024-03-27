<?php
    include("import.php");

    $sql = "SELECT * FROM service_type ORDER BY service_type_name ASC";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $i = 0;
        while($row = $result->fetch_assoc()){
            $output_array['GTS'][$i]['service_type_id'] = (int)$row['service_type_id'];
            $output_array['GTS'][$i]['service_type_name'] = $row['service_type_name'];
            $output_array['GTS'][$i]['service_type_status'] = (int)$row['service_type_status'];

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