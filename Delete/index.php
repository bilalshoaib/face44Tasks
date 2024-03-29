<?php
// required headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding, X-Auth-Token, content-type');
 
// include database and object file
include_once '../config/Database.php';
include_once '../modal/User.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare User object
$user = new User($db);
 
// get User id
$user->id = $_GET['id'];
 
// delete the User
if($user->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "User was deleted."));
}
 
// if unable to delete the User
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete User."));
}
?>