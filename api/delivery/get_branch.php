<?php
    include("../../dashboard/include/connection.php");
    include("../code.php");
    $output_array = array();

    $data = json_decode(file_get_contents('php://input'));

    $sql = "SELECT * FROM branch";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $i = 0;
        while($row = $result->fetch_assoc()){
            $output_array['GTS'][$i]['branch_id'] = (int)$row['login_id'];
            $output_array['GTS'][$i]['branch_name'] = $row['branch_name'];
            $output_array['GTS'][$i]['branch_address'] = $row['branch_address'];
            $output_array['GTS'][$i]['branch_status'] = (int)$row['branch_status'];

            $i++;
        }

        $output_array['status'] = true;
        $output_array['message'] = 'Success';
    } else{
        http_response_code(404);
        $output_array['status'] = false;
        $output_array['message'] = 'Branch not found';
    }

    echo json_encode($output_array);
?>