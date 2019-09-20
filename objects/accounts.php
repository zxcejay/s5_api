<?php
class Accounts{
 
    // database connection and table name
    private $conn;
    private $table_name = "accounts";
 
    // object properties
    public $id;
    public $firstname;
    public $middlename;
    public $lastname;
    public $birthday;
    public $section;
    public $guardian;
    public $address;
    public $contact_number;
    public $username;
    public $password;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
        // select all query
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " a
                ORDER BY
                    a.id ASC";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
        
        return $stmt;

    }

    // used when filling up the update product form
    function readById(){
        // query to read single record
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " a
                WHERE
                    a.id = ?
                LIMIT
                    0,1";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);
     
        // execute query
        $stmt->execute();
     
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->firstname = $row['firstname'];
        $this->middlename = $row['middlename'];
        $this->lastname = $row['lastname'];
        $this->birthday = $row['birthday'];
        $this->section = $row['section'];
        $this->guardian = $row['guardian'];
        $this->address = $row['address'];
        $this->contact_number = $row['contact_number'];
        $this->username = $row['username'];
        $this->password = $row['password'];
    }

    function readByUserPass(){
        // query to read single record
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " a
                WHERE
                    a.username = :username AND a.password = :password
                LIMIT
                    0,1";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of product to be updated
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
     
        // execute query
        $stmt->execute();
     
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // var_dump($row);die();
        if($row['id']) {
            $this->id = $row['id'];
            $this->status = "200"; // success
            $this->validUsername = $this->username;
            $this->validPassword = $this->password;
        }
        else{
            $this->status = "404"; // failed
        }
        
    }

    // update the product
    function update(){
     
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET

                    firstname = :firstname,
                    middlename = :middlename,
                    lastname = :lastname,
                    birthday = :birthday,
                    section = :section,
                    guardian = :guardian,
                    address = :address,
                    contact_number = :contact_number,
                    username = :username,
                    password = :password
                WHERE
                    id = :id";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->middlename=htmlspecialchars(strip_tags($this->middlename));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->birthday=htmlspecialchars(strip_tags($this->birthday));
        $this->section=htmlspecialchars(strip_tags($this->section));
        $this->guardian=htmlspecialchars(strip_tags($this->guardian));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->contact_number=htmlspecialchars(strip_tags($this->contact_number));
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->id=htmlspecialchars(strip_tags($this->id));

     
        // bind new values
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':middlename', $this->middlename);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':birthday', $this->birthday);
        $stmt->bindParam(':section', $this->section);
        $stmt->bindParam(':guardian', $this->guardian);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':contact_number', $this->contact_number);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
     
        // execute the query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }


    }

    // delete the product
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

    // search products
    function search($keywords){
     
        // select all query
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                WHERE
                    p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
                ORDER BY
                    p.created DESC";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
     
        // bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }


    // read products with pagination
    public function readPaging($from_record_num, $records_per_page){
     
        // select query
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                ORDER BY p.created DESC
                LIMIT ?, ?";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
     
        // execute query
        $stmt->execute();
     
        // return values from database
        return $stmt;
    }


    // used for paging products
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        return $row['total_rows'];
    }

}

?>