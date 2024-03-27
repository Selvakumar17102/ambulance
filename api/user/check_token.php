<?php
    include("import.php");

    if(!empty($header['authorization'])){
        $token = $header['authorization'];

        $responceData = checkAndGenerateToken($conn,$token);;

        if($responceData['status']){
            $output_array['status'] = true;
            $output_array['token'] = $responceData['token'];
            $output_array['is_changed'] = $responceData['is_changed'];
            $output_array['message'] = 'Ok';
        } else{
            header($tokenInvalid);
            $output_array['status'] = false;
        }
    } else{
        header($tokenInvalid);
        $output_array['status'] = false;
    }

    echo json_encode($output_array);
?>