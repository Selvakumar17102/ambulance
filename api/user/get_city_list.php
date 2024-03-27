<?php
	include("import.php");

	if(!empty($data->district)){
		$district = $data->district;

		$sql = "SELECT * FROM city WHERE district_id='$district'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
            $i = 0; 
            while($row = $result->fetch_assoc()){
                $output_array["GTS"][$i]['city_id'] = (int)$row['city_id'];
                $output_array["GTS"][$i]['city_name'] = $row['city_name'];
                $i++;
            }
		} else{
			http_response_code(500);
			$output_array['status'] = false;
			$output_array['message'] = "city not found";
		}
	} else{
		http_response_code(400);
		$output_array['status'] = false;
		$output_array['message'] = "Bad request";
	}

	echo json_encode($output_array);
?>