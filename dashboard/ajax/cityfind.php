<?php
    include('../include/connection.php');
	include("../../api/password.php");

    if(isset($_POST['id'])){
		$id = $_POST["id"];

        $sql= "SELECT * FROM city WHERE district_id='$id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
           $city="<option value=''>Select city name</option>";
            while($row = $result->fetch_assoc()){
                $city.= "<option value=".$row['city_id'].">".$row['city_name']."</option>";
            }
            echo $city;
        }

	}
?>