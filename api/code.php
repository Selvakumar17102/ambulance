<?php
    header('Content-Type: application/json');

    $badRequest = "HTTP/1.0 900 Bad Request";
    $tokenInvalid = "HTTP/1.0 901 Unauthorized";
    $paymentRequired = "HTTP/1.0 902 Payment Required";
    $inValid = "HTTP/1.0 903 In Valid";
    $notFound = "HTTP/1.0 904 Not Found";
    $server = "HTTP/1.0 905 Internal Server Error";
?>