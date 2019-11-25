<?php
// required headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding, X-Auth-Token, content-type');
 
// include database and object files
include_once '../config/Database.php';
include_once '../modal/User.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare User object
$user = new User($db);
 
// set ID property of record to read
$user->id = isset($_GET['id']) ? $_GET['id'] : '';
// read the details of User to be edited
$user->readOne();
if($user->name){
    // create array
    $user_arr = array(
        "id" =>  $user->id,
        "name" => $user->name,
        "email" => $user->email,
        "address" => $user->address,
        "phone" => $user->phone
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($user_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user User does not exist
    echo json_encode(array("message" => "User does not exist."));
}
?>