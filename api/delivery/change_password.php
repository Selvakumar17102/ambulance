<?php
    include("import.php");
    ini_set('display_errors','off');

    if(!empty($data->password) && !empty($data->user_id)){
        $user_id = $data->user_id;
        $password = $data->password;

        $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$user_id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){

            $passwordResponce = json_decode(generatePass($conn,$password));

            $NewPass = $passwordResponce->password;
            $cipher = $passwordResponce->cipher;

            $sql = "UPDATE delivery_partner SET delivery_partner_password='$NewPass',delivery_partner_cipher='$cipher' WHERE delivery_partner_id='$user_id'";
            if($conn->query($sql) === TRUE){
                $output_array['status'] = true;
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

    echo json_encode($output_array);
?>