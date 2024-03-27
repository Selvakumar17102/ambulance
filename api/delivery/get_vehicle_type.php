<?php
    include("../../dashboard/include/connection.php");
    include("../code.php");
    $output_array = array();

    $data = json_decode(file_get_contents('php://input'));

    $sql = "SELECT * FROM category";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $i = 0;
        while($row = $result->fetch_assoc()){
            $output_array['GTS'][$i]['vehicle_type_id'] = (int)$row['category_id'];
            $output_array['GTS'][$i]['vehicle_type_name'] = $row['category_name'];

            $i++;
        }

        $output_array['status'] = true;
        $output_array['message'] = 'Success';
    } else{
        http_response_code(404);
        $output_array['status'] = false;
        $output_array['message'] = 'Vehicle type not found';
    }

    echo json_encode($output_array);
?>