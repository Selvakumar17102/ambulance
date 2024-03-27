<?php
    include('../include/connection.php');
	include("../../api/password.php");

    if(isset($_POST['id'])){
		$id = $_POST["id"];

        $sql= "SELECT * FROM district WHERE state_id='$id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $district = "<option value=''>Select district name</option>";
            while($row = $result->fetch_assoc()){
                $district .= "<option value=".$row['did'].">".$row['district_name']."</option>";
            }
            echo $district;
        }

	}
?>