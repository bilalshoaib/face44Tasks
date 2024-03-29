<?php
// required headers
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Accept, content-type');
header('Content-Type: text/plain');
header('Access-Control-Allow-Credentials: true');

// get database connection
include_once '../config/Database.php';
 
// instantiate product object
include_once '../modal/User.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->email) &&
    !empty($data->address) &&
    !empty($data->phone)
){
 
    // set user property values
    $user->name = $data->name;
    $user->email = $data->email;
    $user->address = $data->address;
    $user->phone = $data->phone;
    // $user->created = date('Y-m-d H:i:s');
 
    // create the product
    if($user->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "User was created."));
    }
 
    // if unable to create the user, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create User."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create User. Data is incomplete."));
}
?>