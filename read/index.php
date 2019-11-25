<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding, X-Auth-Token, content-type');
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../modal/User.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$user = new User($db);
 
// read products will be here

// query products
$stmt = $user->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $user_arr=array();
    $user_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        
        extract($row);
 
        $user_item=array(
            "id" => $id,
            "U_name" => $U_name,
            "email" => $email,
            "address" => $address,
            "phone" => $phone
        );
 
        array_push($user_arr["records"], $user_item);
    }
 	if (count($user_arr["records"]) > 0) {
 		# code...
 		http_response_code(200);
 
    // show products data in json format
    echo json_encode($user_arr);
 	}
 	else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}
    // set response code - 200 OK
    
}
 
// no products found will be here

