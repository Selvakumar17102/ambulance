<?php
	include("vendor/autoload.php");
	date_default_timezone_set('UTC');
	use \Firebase\JWT\JWT;
	JWT::$leeway = 10;
	function createToken($conn,$login_id){
		$sql = "SELECT * FROM app_control WHERE app_control_id='1'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();

		$secret_key = $row['jwt_secret'];

		$issuer_claim = $_SERVER['SERVER_NAME'];
		$issuedat_claim = microtime(true);
		$current_expire_claim = $issuedat_claim + 900;
		$refresh_expire_claim = $issuedat_claim + 604800;

		$current_token = array(
			"iss" => $issuer_claim,
			"iat" => $issuedat_claim,
			"nbf" => $issuedat_claim,
			"exp" => $current_expire_claim,
			"user_id" => (int)$login_id
		);

		$refresh_token = array(
			"iss" => $issuer_claim,
			"iat" => $issuedat_claim,
			"nbf" => $issuedat_claim,
			"exp" => $refresh_expire_claim,
			"user_id" => (int)$login_id
		);

		$out['current_token'] = JWT::encode($current_token, $secret_key);
		$out['refresh_token'] = JWT::encode($refresh_token, $secret_key);

		return $out;
	}

	function checkAndGenerateToken($conn,$token){
		$sql = "SELECT * FROM app_control WHERE app_control_id='1'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();

		$secret_key = $row['jwt_secret'];
		try {
			$decoded = JWT::decode($token, $secret_key, array('HS256'));

			$res['status'] = 1;
			$res['user_id'] = (int)$decoded->user_id;
			$res['token'] = $token;
			$res['is_changed'] = false;
		} catch (Exception $e) {
			if($e->getMessage() == 'Expired token'){
				list($header, $payload, $signature) = explode(".", $token);

				$user_id = json_decode(base64_decode($payload))->user_id;

				$sql = "SELECT * FROM user WHERE user_id='$user_id' AND refresh_token!=''";
				$result = $conn->query($sql);
				if($result->num_rows > 0){
					$row = $result->fetch_assoc();

					$refresh_token = $row['refresh_token'];

					try {
						$decoded = JWT::decode($refresh_token, $secret_key, array('HS256'));
			
						$new_token_response = createToken($conn,$user_id);

						$new_refresh_token = $new_token_response['refresh_token'];

						$sql = "UPDATE user SET refresh_token='$new_refresh_token' WHERE user_id='$user_id'";
						if($conn->query($sql) === TRUE){
							$res['status'] = 1;
							$res['user_id'] = $user_id;
							$res['token'] = $new_token_response['current_token'];
							$res['is_changed'] = true;
						}
					} catch (Exception $e) {
						$haystack = $e->getMessage();
						$needle = 'handle token prior';

						if (strpos($haystack, $needle) !== false) {
							$res['status'] = 1;
							$res['msg'] = 'Please retry';
							$res['token'] = $token;
							$res['is_changed'] = false;
						} else{
							$res['status'] = 0;
							$res['msg'] = $haystack;
						}
					}
				} else{
					$res['status'] = 0;
					$res['msg'] = 'expired';
					$res['query'] = $sql;
				}
			} else{
				$haystack = $e->getMessage();
				$needle = 'handle token prior';

				if (strpos($haystack, $needle) !== false) {
					$res['status'] = 1;
					$res['msg'] = 'Please retry';
					$res['token'] = $token;
					$res['is_changed'] = false;
				} else{
					$res['status'] = 0;
					$res['msg'] = $haystack;
				}
			}
		}
		return $res;
	}
?>