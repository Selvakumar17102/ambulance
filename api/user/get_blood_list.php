<?php
    include("import.php");

    $sql = "SELECT * FROM bloodlist";
    $result = $conn->query($sql);
    $i = 0; 
    while($row = $result->fetch_assoc()){
        $output_array["GTS"][$i]['blood_id'] = (int)$row['blood_id'];
        $output_array["GTS"][$i]['blood_name'] = $row['blood_name'];

        $i++;

    }
    echo json_encode($output_array);
?>