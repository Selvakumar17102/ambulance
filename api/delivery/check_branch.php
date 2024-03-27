<?php
    include("../../dashboard/include/connection.php");
    include("../code.php");
    $output_array = array();

    $data = json_decode(file_get_contents('php://input'));

    $sql = "SELECT * FROM branch WHERE branch_status='1' ORDER BY branch_name ASC";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $i = 0;
        while($row = $result->fetch_assoc()){
            $output_array['GTS'][$i]['branch_id'] = $row['login_id'];
            $output_array['GTS'][$i]['branch_name'] = $row['branch_name'];

            $i++;
        }
        $output_array['status'] = true;
        $output_array['message'] = 'Success';
    } else{
        header($notFound);
        $output_array['status'] = false;
        $output_array['message'] = 'Branch not found';
    }

    echo json_encode($output_array);
?>