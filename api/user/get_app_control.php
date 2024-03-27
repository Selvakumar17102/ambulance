<?php
    include("import.php");
    date_default_timezone_set("Asia/Calcutta");
    $today = date("Y-m-d");

    $sql = "SELECT ios_latest_features,ios_version_name,ios_version_code,android_latest_features,android_version_name,android_version_code,refer_earn,minimum_convertible_points,delete_account_content,linkedin_url,youtube_url,facebook_url,instagram_url,instant_service_time,razorpay_merchant_key,minimum_order,app_intime,app_outtime,app_version,cart_count,eggless,contact_number,map_key,contact_us,privacy_policy,about_us,terms,self_pickup_status,otp_message,faq,blog,cancellation_policy,certificates,mt_way,loginscreen_image,splash_image,wallet_banner,membership_image,mt_way_image,referral_image,mt_deals_image,mt_deals_icon,service_not_available_content,instant_order_closing_time FROM app_control WHERE app_control_id='1'";
    $result = $conn->query($sql);
    $output_array['GTS'] = $result->fetch_assoc();

    $output_array['GTS']['self_pickup_status'] = (int)$output_array['GTS']['self_pickup_status'];
    $output_array['GTS']['instant_service_time'] = (int)$output_array['GTS']['instant_service_time'];
    $output_array['GTS']['instant_order_closing_time_UTC'] = strtotime($output_array['GTS']['instant_order_closing_time'].' '.$today);

    $output_array['GTS']['loginscreen_image'] = $IMAGE_BASE_URL.$output_array['GTS']['loginscreen_image'];
    $output_array['GTS']['wallet_banner'] = $IMAGE_BASE_URL.$output_array['GTS']['wallet_banner'];
    $output_array['GTS']['splash_image'] = $IMAGE_BASE_URL.$output_array['GTS']['splash_image'];

    $output_array['GTS']['membership_image'] = $IMAGE_BASE_URL.$output_array['GTS']['membership_image'];
    $output_array['GTS']['mt_way_image'] = $IMAGE_BASE_URL.$output_array['GTS']['mt_way_image'];
    $output_array['GTS']['referral_image'] = $IMAGE_BASE_URL.$output_array['GTS']['referral_image'];
    $output_array['GTS']['mt_deals_image'] = $IMAGE_BASE_URL.$output_array['GTS']['mt_deals_image'];
    $output_array['GTS']['mt_deals_icon'] = $IMAGE_BASE_URL.$output_array['GTS']['mt_deals_icon'];

    $sql = "SELECT * FROM app_version ORDER BY app_version_id DESC LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $output_array['GTS']['app_version'] = $row['app_version_name'];

    $output_array['status'] = true;

    echo json_encode($output_array);
?>