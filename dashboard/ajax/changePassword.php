<?php
    include('../include/connection.php');
	include("../../api/password.php");
	include("../../api/passwordGenerator.php");
    
    if(!empty($_POST['password'])){
        $password = $_POST['password'];
        $newPassword = $_POST['newPassword'];

        $sql = "SELECT * FROM login WHERE login_id='1'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			$row = $result->fetch_assoc();

            if(chechPass($conn,$row['password'],$row['cipher'],$password)){
				$passwordResponce = json_decode(generatePass($conn,$newPassword));

				$NewPass = $passwordResponce->password;
            	$cipher = $passwordResponce->cipher;

                $sql = "UPDATE login SET password='$NewPass',cipher='$cipher' WHERE login_id='1'";
                if($conn->query($sql) === TRUE){
                    echo 'success';
                }
			} else{
				echo "Incorrect Old Password!";
			}
        }
    }
?>