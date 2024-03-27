<?php
	include("import.php");

	if(!empty($data->state)){
		$state = $data->state;

		$sql = "SELECT * FROM district WHERE state_id='$state'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
            $i = 0; 
            while($row = $result->fetch_assoc()){
                $output_array["GTS"][$i]['did'] = (int)$row['did'];
                $output_array["GTS"][$i]['district_name'] = $row['district_name'];
                $i++;
            }
		} else{
			http_response_code(500);
			$output_array['status'] = false;
			$output_array['message'] = "District not found";
		}
	} else{
		http_response_code(400);
		$output_array['status'] = false;
		$output_array['message'] = "Bad request";
	}

	echo json_encode($output_array);
?>