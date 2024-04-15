<?php
	include("import.php");

	if(!empty($data->type)){
		$type = $data->type;

		$sql = "SELECT * FROM request_reason WHERE type='$type'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			$i = 0; 
			while($row = $result->fetch_assoc()){
				$output_array["GTS"][$i]['reason_id'] = (int)$row['reason_id'];
				$output_array["GTS"][$i]['reason'] = $row['reason'];
				$i++;
			}
			$output_array['status'] = true;
			$output_array['message'] = "Success";
		}
		else{
			http_response_code(500);
			$output_array['status'] = false;
			$output_array['message'] = "No Resons available !";
		}
	}else{
		http_response_code(400);
		$output_array['status'] = false;
		$output_array['message'] = "Bad request";
	}


	echo json_encode($output_array);
?>