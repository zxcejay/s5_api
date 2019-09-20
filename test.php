<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
 
// instantiate database and product object
class Database{
 
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "id721699_ionic_2";
    private $username = "id721699_ionic_2";
    private $password = "Palits16";
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}

$database = new Database();
$db = $database->getConnection();

function readAccounts(){
        // select all query
        $query = "SELECT
                    *
                FROM
                    accounts a";
     
        // prepare query statement
        $stmt = $this->db->prepare($query);
     
        // execute query
        $stmt->execute();
        
        return $stmt;

    }
$stmt = readAccounts();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        var_dump($row);
    }

?>