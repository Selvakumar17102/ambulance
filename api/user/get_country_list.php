<?php
    include("import.php");

    $sql = "SELECT * FROM country";
    $result = $conn->query($sql);
    $i = 0; 
    while($row = $result->fetch_assoc()){
        $output_array["GTS"][$i]['cid'] = (int)$row['cid'];
        $output_array["GTS"][$i]['country_name'] = $row['country_name'];

        $i++;

    }
    echo json_encode($output_array);
?>