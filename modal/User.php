<?php 
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "user_tbl";
 
    // object properties
    public $id;
    public $name;
    public $email;
    public $address;
    public $phone;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // / read User
function read(){
 
    // select all query
    $query = "SELECT id, U_name, email, address, phone from " . $this->table_name;
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
// create User
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                U_name=:name, email=:email, address=:address, phone=:phone";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->address=htmlspecialchars(strip_tags($this->address));
    $this->phone=htmlspecialchars(strip_tags($this->phone));
    // $this->created=htmlspecialchars(strip_tags($this->created));
 
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":address", $this->address);
    $stmt->bindParam(":phone", $this->phone);
    // $stmt->bindParam(":created", $this->created);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
// update the User
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                U_name = :name,
                email = :email,
                address = :address,
                phone = :phone
            WHERE
                id = :id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->address=htmlspecialchars(strip_tags($this->address));
    $this->phone=htmlspecialchars(strip_tags($this->phone));
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':address', $this->address);
    $stmt->bindParam(':phone', $this->phone);
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
// delete the User
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
// used when filling up the update User form
function readOne(){
 
    // query to read single record
    $query = "SELECT *  FROM " . $this->table_name . " WHERE id =:id";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of User to be updated
    $stmt->bindParam(':id', $this->id);
    
 
    // execute querys
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties

    $this->name = $row['U_name'];
    $this->email = $row['email'];
    $this->address = $row['address'];
    $this->phone = $row['phone'];
}
}
 ?>