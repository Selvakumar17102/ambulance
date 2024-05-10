<?php
    include("import.php");

    $sql = "SELECT * FROM news";
    $result = $conn->query($sql);
    $i = 0; 
    while($row = $result->fetch_assoc()){
        $output_array["GTS"][$i]['id'] = (int)$row['id'];
        $output_array["GTS"][$i]['news_text'] = $row['news_text'];

        $i++;

    }
    echo json_encode($output_array);
?>