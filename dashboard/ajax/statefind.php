<?php
    include('../include/connection.php');
	include("../../api/password.php");

    if(isset($_POST['id'])){
		$id = $_POST["id"];

        $sql= "SELECT * FROM state WHERE country_id='$id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $state= "<option value=''>Select state name</option>";
            while($row = $result->fetch_assoc()){
                $state .= "<option value=".$row['sid'].">".$row['state_name']."</option>";
            }
            echo $state;
        }

	}
?>