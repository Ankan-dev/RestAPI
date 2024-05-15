<?php

error_reporting(0);

header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-headers: Content-Type,Access-Control-Allow-Headers,Authorization,X-Request-with');

include('function.php');

$requestMethod=$_SERVER["REQUEST_METHOD"];

if($requestMethod=="POST"){

   $inputData= json_decode(file_get_contents("php://input"),true);
    if(empty($inputData)){
        $storeCustomer= storeCustomer($_POST);
    }else{
        $storeCustomer=storeCustomer($inputData);
    }
    echo $storeCustomer;

}else{
    $data=[
        'status'=>405,
        'message'=>$requestMethod.'Method not found',
    ];
    header("HTTP/1.0 405 Method not found");
    echo json_encode($data);
}
?>