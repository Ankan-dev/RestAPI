<?php

error_reporting(0);

header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-headers: Content-Type,Access-Control-Allow-Headers,Authorization,X-Request-with');

include('function.php');

$requestMethod=$_SERVER["REQUEST_METHOD"];

if($requestMethod=="DELETE"){
    $delete=deleteCustomer($_GET);
    echo $delete;
}else{
    $data=[
        'status'=>405,
        'message'=>$requestMethod.'Method not found',
    ];
    header("HTTP/1.0 405 Method not found");
    echo json_encode($data);
}
?>