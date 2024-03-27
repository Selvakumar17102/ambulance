<?php
    include('../include/connection.php');
	include("../../api/password.php");

    if(isset($_POST['username'])){
		$username = $_POST["username"];
		$password = $_POST["password"];

		$sql = "SELECT * FROM login WHERE BINARY username='$username'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			$row = $result->fetch_assoc();

			if(chechPass($conn,$row['password'],$row['cipher'],$password)){
				echo $row["login_id"];
			} else{
				echo "Incorrect Password!";
			}
		} else{
			echo "Invalid Username!";
		}
	}
?>