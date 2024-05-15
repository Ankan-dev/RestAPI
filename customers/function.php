<?php

require '../inc/dbcon.php';

function errorMsg($message){
    $data=[
        'status'=>422,
        'message'=>$message,
    ];
    header("HTTP/1.0 500".$message);
    return json_encode($data);
}

function storeCustomer($input){
    global $conn;

    $name = mysqli_real_escape_string($conn,$input['name']);
    $email=mysqli_real_escape_string($conn,$input['email']);
    $phone=mysqli_real_escape_string($conn,$input['phone']);
    if(empty(trim($name))){
        return errorMsg("Enter your name");
    }
    else if(empty(trim($email))){
        return errorMsg("Enter your email");
    }
    else if(empty(trim($phone))){
        return errorMsg("Enter your phone number");
    }
    else{
        $query= "INSERT INTO customers (name, email, phone) VALUES ('$name', '$email', '$phone')";
        $result = mysqli_query($conn,$query);
        if($result){
            $data=[
                'status'=>201,
                'message'=>"Customer created successfully",
            ];
            header("HTTP/1.0 201 successful");
            return json_encode($data);
        }else{
            $data=[
                'status'=>500,
                'message'=>"Internal Server Error",
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}

function getCustomerList()
{
    global $conn;

    $query = "SELECT * FROM customers";

    $query_run = mysqli_query($conn, $query);

    if($query_run){
        if(mysqli_num_rows($query_run)>0){

            $res=mysqli_fetch_all($query_run,MYSQLI_ASSOC);
            $data=[
                'status'=>200,
                'message'=>"customer fetched successfully",
                'data'=>$res
            ];
            header("HTTP/1.0 200 customer fetched successfully");
            return json_encode($data);
        }else{
            $data=[
                'status'=>404,
                'message'=>"No customer found",
            ];
            header("HTTP/1.0 404 No customer found");
            return json_encode($data);
        }

    }else{
        $data=[
            'status'=>500,
            'message'=>"Internal Server Error",
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function getCustomer($customerParams){
    global $conn;
    if($customerParams['id']==null){
        return errorMsg("Enter your id");
    }
    $customerId=mysqli_real_escape_string($conn,$customerParams['id']);

    $query= "SELECT * FROM customers WHERE id='$customerId' LIMIT 1";

    $res=mysqli_query($conn,$query);
    if($res){
        if(mysqli_num_rows($res)==1){
            $result=mysqli_fetch_assoc($res);
            $data=[
                'status'=>200,
                'message'=>"customer received",
                'data'=>$result
            ];
            header("HTTP/1.0 200 customer received");
            return json_encode($data);

        }else{
            $data=[
                'status'=>404,
                'message'=>"No customer found",
            ];
            header("HTTP/1.0 404 No customer found");
            return json_encode($data);
        }

    }else{
        $data=[
            'status'=>500,
            'message'=>"Internal Server Error",
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function updateCustomer($input,$customerParams){
    global $conn;

    if(!isset($customerParams)){
        return errorMsg("Id not found");
    }else if($customerParams==null){
        return errorMsg("Enter your id");
    }

    $id = mysqli_real_escape_string($conn,$customerParams['id']);

    $name = mysqli_real_escape_string($conn,$input['name']);
    $email=mysqli_real_escape_string($conn,$input['email']);
    $phone=mysqli_real_escape_string($conn,$input['phone']);
    if(empty(trim($name))){
        return errorMsg("Enter your name");
    }
    else if(empty(trim($email))){
        return errorMsg("Enter your email");
    }
    else if(empty(trim($phone))){
        return errorMsg("Enter your phone number");
    }
    else{
        $query= "UPDATE customers SET name='$name', email='$email', phone='$phone' WHERE id='$id' LIMIT 1";
        $result = mysqli_query($conn,$query);
        if($result){
            $data=[
                'status'=>200,
                'message'=>"Customer Updated successfully",
            ];
            header("HTTP/1.0 200 successful");
            return json_encode($data);
        }else{
            $data=[
                'status'=>500,
                'message'=>"Internal Server Error",
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}

function deleteCustomer($customerParams){
    global $conn;

    if(!isset($customerParams)){
        return errorMsg("Id not found");
    }else if($customerParams==null){
        return errorMsg("Enter your id");
    }

    $id = mysqli_real_escape_string($conn,$customerParams['id']);

    $query="DELETE FROM customers WHERE id='$id' LIMIT 1";
    $result =mysqli_query($conn,$query);
    if($result){
        $data=[
            'status'=>200,
            'message'=>"customer deleted successfully",
        ];
        header("HTTP/1.0 200 customer deleted successfully");
        return json_encode($data);
    }else{
        $data=[
            'status'=>404,
            'message'=>"customer not found",
        ];
        header("HTTP/1.0 404 customer not found");
        return json_encode($data);
    }
}