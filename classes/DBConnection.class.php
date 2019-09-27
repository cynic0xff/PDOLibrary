<?php

class DBConnection {

    //TODO: Move to a settings files
    private $host = "localhost";
    private $user = "root";
    private $db = "world";
    private $pass = "hwyaa370";
    private $conn;
    
    public function __construct() {
        
        //create the PDO connection
        $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->pass);
    }
    
    //display data
    public function showData($table) {
        
        //create the sql query
        $sql = "SELECT * FROM $table";
        $q = $this->conn->query($sql) or die("failed!");
        
        //populate the data array
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $r;
        }

        //return the data
        return $data;
    }
    
    //get the data by ID,
    public function getById($id, $table) {
        
        $sql = "SELECT * FROM $table WHERE id = :id";
        
        //prep the sql
        $q = $this->conn->prepare($sql);
        
        //execute and return the id
        $q->execute(array(
            ':id' => $id
        ));

        //fetch the data
        $data = $q->fetch(PDO::FETCH_ASSOC);

        //return the id
        return $data;
    }
    
    //update
    public function update($id, $name, $email, $mobile, $address, $table) {
        
        //create the sql statemenet
        $sql = "UPDATE $table SET name=:name,email=:email,mobile=:mobile,address=:address WHERE id=:id";

        //pre the sql
        $q = $this->conn->prepare($sql);

        //execute the update
        $q->execute(array(
            ':id' => $id,
            ':name' => $name,
            ':email' => $email,
            ':mobile' => $mobile,
            ':address' => $address
        ));

        //TODO: return ids of update
        return true;
        
    }
    
    //insert
    public function insertData($table, $name, $color) {

        $sql = "INSERT INTO $table SET 
            name=:name, 
            color=:color";

        $q   = $this->conn->prepare($sql);
        $q->execute(array(
            ':name' => $name,
            ':color' => $color
        ));

        //return the id of the last entry
        return $this->conn->lastInsertId();

    }
    
    //delete
    public function deleteData($id, $table) {
        
        $sql = "DELETE FROM $table WHERE id=:id";

        //prep the sql
        $q   = $this->conn->prepare($sql);

        //execute the 
        $q->execute(array(
            ':id' => $id
        ));
        return true;
    }
}


//create a test instance
$o = new DBConnection();

//get
print_r($o->getById(1, 'city'));

//loop through the array
foreach($o->getById(1, 'city') as $city) {
    echo $city . "\n";
}

//insert
$result = $o->insertData('cars', 'Lexus', 'Green');

echo 'Result: ' . $result;

?>
