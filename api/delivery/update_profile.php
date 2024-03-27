<?php
    include("import.php");
    ini_set('display_errors','off');

    if(!empty($header['authorization'])){
		$token = $header['authorization'];

		$responceData = checkAndGenerateToken($conn,$token);

		if($responceData['status']){
			$user_id = $responceData['user_id'];
			$responceToken = $responceData['token'];

			header('authorization: ' . $responceToken);

            if(!empty($_POST["name"])){
                $name = $_POST["name"];
                $image = $_FILES["image"];
                $phone = $_POST["mobile"];
                $delivery_partner_email = $_POST["email"];
                $delivery_partner_alternate_mobile = $_POST["alternate_mobile"];
                $gender = $_POST["gender"];
                $local_charge = $_POST["local_charge"];
                $local_min_distance = $_POST["local_min_distance"];
                $local_extra_charge_per_km = $_POST["local_extra_charge_per_km"];
                $long_min_distance = $_POST["long_min_distance"];
                $long_charge = $_POST["long_charge"];
                $long_max_distance = $_POST["long_max_distance"];
                $long_extra_charge_per_km = $_POST["long_extra_charge_per_km"];
                $vehicle_type = $_POST["vehicle_type_id"];
                $delivery_partner_blood_group = mysqli_real_escape_string($conn, $_POST["blood_group"]);
                $branch_id = $_POST["branch_id"];
                $vehicle_name = $_POST["vehicle_name"];
                $vehicle_number = $_POST["vehicle_number"];
                $license_number = $_POST["license_number"];
                $aadhaar_number = $_POST["aadhaar_number"];
                $hospital_name = $_POST["hospital_name"];
                $delivery_partner_date_of_birth = date('Y-m-d',strtotime($_POST["date_of_birth"]));
                $delivery_partner_address = mysqli_real_escape_string($conn, $_POST["address"]);
                $license = $_FILES['license'];
                $rc_book = $_FILES['rc_book'];
                $vehicle_image = $_FILES['vehicle_image'];
                $aadhaar = $_FILES['aadhaar'];
                $date = date('Y_m_d_h_i_s');

                $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$user_id'";
                $result = $conn->query($sql);
                if($result->num_rows){
                    // $sql = "UPDATE delivery_partner SET delivery_partner_branch_id='$branch_id',delivery_partner_name='$name',delivery_partner_date_of_birth='$delivery_partner_date_of_birth',delivery_partner_gender='$gender',local_charge='$local_charge',local_min_distance='$local_min_distance',local_extra_charge_per_km='$local_extra_charge_per_km',long_charge='$long_charge',long_min_distance='$long_min_distance',long_max_distance='$long_max_distance',long_extra_charge_per_km='$long_extra_charge_per_km',vehicle_type='$vehicle_type',delivery_partner_vehicle_name='$vehicle_name',delivery_partner_vehicle_number='$vehicle_number',license_number='$license_number',delivery_partner_address='$delivery_partner_address',delivery_partner_alternate_mobile='$delivery_partner_alternate_mobile',delivery_partner_blood_group='$delivery_partner_blood_group',delivery_partner_email='$delivery_partner_email',aadhaar_number='$aadhaar_number',hospital_name='$hospital_name' WHERE delivery_partner_id='$user_id'";
                    $sql = "UPDATE delivery_partner SET delivery_partner_name='$name',local_charge='$local_charge',local_min_distance='$local_min_distance',local_extra_charge_per_km='$local_extra_charge_per_km',long_charge='$long_charge',long_min_distance='$long_min_distance',long_max_distance='$long_max_distance',long_extra_charge_per_km='$long_extra_charge_per_km',delivery_partner_address='$delivery_partner_address',delivery_partner_alternate_mobile='$delivery_partner_alternate_mobile' WHERE delivery_partner_id='$user_id'";
                    if($conn->query($sql) === TRUE){
    
                        $upload_dir = 'uploads'.DIRECTORY_SEPARATOR;
                        $allowed_types = array('jpg','JPG','png','PNG','jpeg','JPEG');
    
                        if(!empty(array_filter($_FILES['license']['name']))) {
                            $sql3 = "DELETE FROM driver_image_file WHERE driver_id = $user_id AND type = 1";
                            $conn->query($sql3);

                            for($i=0; $i < count($_FILES['license']['tmp_name']);$i++) {
    
                                $file_tmpname = $_FILES['license']['tmp_name'][$i];
                                $file_name = $_FILES['license']['name'][$i];
                                $file_size = $_FILES['license']['size'][$i];
                                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    
                                $fName = $user_id."_".$i;
    
                                $upload_dir = "Images/License/$fName.$file_ext";
    
                                if(in_array(strtolower($file_ext), $allowed_types)) {
    
                                    $ImagePath = "../../dashboard/$upload_dir";
    
                                    if( move_uploaded_file($file_tmpname, $ImagePath)) {
                                        $sql3 = "INSERT INTO driver_image_file (driver_id,image,type) VALUES ('$user_id','$upload_dir','1')";
                                        $conn->query($sql3);
    
                                        http_response_code(200);
                                        $output_array['status'] = true;
                                    } else {					
                                        http_response_code(200);
                                        $output_array['status'] = false;
                                        $output_array['message'] = 'Image Upload Failed';
                                    }
                                }
                            }
                        }
    
                        if(!empty(array_filter($_FILES['rc_book']['name']))) {
                            $sql3 = "DELETE FROM driver_image_file WHERE driver_id = $user_id AND type = 2";
                            $conn->query($sql3);

                            for($i=0; $i < count($_FILES['rc_book']['tmp_name']);$i++) {
    
                                $file_tmpname = $_FILES['rc_book']['tmp_name'][$i];
                                $file_name = $_FILES['rc_book']['name'][$i];
                                $file_size = $_FILES['rc_book']['size'][$i];
                                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    
                                $fName = $user_id."_".$i;
    
                                $upload_dir = "Images/RC_Book/$fName.$file_ext";
    
                                if(in_array(strtolower($file_ext), $allowed_types)) {
    
                                    $ImagePath = "../../dashboard/$upload_dir";
    
                                    if( move_uploaded_file($file_tmpname, $ImagePath)) {
                                        $sql3 = "INSERT INTO driver_image_file (driver_id,image,type) VALUES ('$user_id','$upload_dir','2')";
                                        $conn->query($sql3);
    
                                        http_response_code(200);
                                        $output_array['status'] = true;
                                    } else {					
                                        http_response_code(200);
                                        $output_array['status'] = false;
                                        $output_array['message'] = 'Image Upload Failed';
                                    }
                                }
                            }
                        }
    
                        if(!empty(array_filter($_FILES['vehicle_image']['name']))) {
                            $sql3 = "DELETE FROM driver_image_file WHERE driver_id = $user_id AND type = 3";
                            $conn->query($sql3);

                            for($i=0; $i < count($_FILES['vehicle_image']['tmp_name']);$i++) {
    
                                $file_tmpname = $_FILES['vehicle_image']['tmp_name'][$i];
                                $file_name = $_FILES['vehicle_image']['name'][$i];
                                $file_size = $_FILES['vehicle_image']['size'][$i];
                                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    
                                $fName = $user_id."_".$i;
    
                                $upload_dir = "Images/Vehicle_Image/$fName.$file_ext";
    
                                if(in_array(strtolower($file_ext), $allowed_types)) {
    
                                    $ImagePath = "../../dashboard/$upload_dir";
    
                                    if( move_uploaded_file($file_tmpname, $ImagePath)) {
                                        $sql3 = "INSERT INTO driver_image_file (driver_id,image,type) VALUES ('$user_id','$upload_dir','3')";
                                        $conn->query($sql3);
    
                                        http_response_code(200);
                                        $output_array['status'] = true;
                                    } else {					
                                        http_response_code(200);
                                        $output_array['status'] = false;
                                        $output_array['message'] = 'Image Upload Failed';
                                    }
                                }
                            }
                        }
    
                        if(!empty(array_filter($_FILES['aadhaar']['name']))) {
                            $sql3 = "DELETE FROM driver_image_file WHERE driver_id = $user_id AND type = 4";
                            $conn->query($sql3);

                            for($i=0; $i < count($_FILES['aadhaar']['tmp_name']);$i++) {
    
                                $file_tmpname = $_FILES['aadhaar']['tmp_name'][$i];
                                $file_name = $_FILES['aadhaar']['name'][$i];
                                $file_size = $_FILES['aadhaar']['size'][$i];
                                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    
                                $fName = $user_id."_".$i;
    
                                $upload_dir = "Images/Aadhaar/$fName.$file_ext";
    
                                if(in_array(strtolower($file_ext), $allowed_types)) {
    
                                    $ImagePath = "../../dashboard/$upload_dir";
    
                                    if( move_uploaded_file($file_tmpname, $ImagePath)) {
                                        $sql3 = "INSERT INTO driver_image_file (driver_id,image,type) VALUES ('$user_id','$upload_dir','4')";
                                        $conn->query($sql3);
    
                                        http_response_code(200);
                                        $output_array['status'] = true;
                                    } else {					
                                        http_response_code(200);
                                        $output_array['status'] = false;
                                        $output_array['message'] = 'Image Upload Failed';
                                    }
                                }
                            }
                        }
    
                        if(!empty($_FILES['image']['name'])){
                            $type=pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
                            $path="Images/Delivery/$user_id.$type";
                            $ImagePath = "../../dashboard/$path";
    
                            $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG');
                            if(in_array($type, $allowTypes)){
                                if(move_uploaded_file($_FILES["image"]["tmp_name"], $ImagePath)){
                                    $sql2 = "UPDATE delivery_partner SET delivery_partner_image = '$path' WHERE delivery_partner_id='$user_id'";
                                    $conn->query($sql2);
                                } 
                            }
                        }

                        http_response_code(200);
                        $output_array['status'] = true;
                    } else{
                        http_response_code(500);
                        $output_array['status'] = false;
                        $output_array['query'] = $sql;
                    }
                } else{
                    http_response_code(404);
                    $output_array['status'] = false;
                    $output_array['message'] = 'Delivery partner not found';
                }
            } else{
                http_response_code(400);
                $output_array['status'] = false;
                $output_array['message'] = 'Bad Request';
            }
        } else{
			http_response_code(401);
            $output_array['status'] = false;
            $output_array['message'] = "Invalid Authentication";
		}
	} else{
		http_response_code(401);
        $output_array['status'] = false;
        $output_array['message'] = "Authentication Missing";
	}

    echo json_encode($output_array);
?>