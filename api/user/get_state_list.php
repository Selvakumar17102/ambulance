<?php
	include("import.php");

	if(!empty($data->country)){
		$country = $data->country;

		$sql = "SELECT * FROM state WHERE country_id='$country'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
            $i = 0; 
            while($row = $result->fetch_assoc()){
                $output_array["GTS"][$i]['sid'] = (int)$row['sid'];
                $output_array["GTS"][$i]['state_name'] = $row['state_name'];
                $i++;
            }
		} else{
			http_response_code(500);
			$output_array['status'] = false;
			$output_array['message'] = "state not found";
		}
	} else{
		http_response_code(400);
		$output_array['status'] = false;
		$output_array['message'] = "Bad request";
	}

	echo json_encode($output_array);
?>