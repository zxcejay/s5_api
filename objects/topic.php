<?php
class Topic{
 
    // database connection and table name
    private $conn;
    private $table_name = "topics";
 
    // object properties
    public $topic_id;
    public $title;
    public $content;
    public $video_link;
    public $quarter_id;
    public $status;
    public $exercise;
    public $quiz;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                title=:title, content=:content, video_link=:video_link, 
                quarter_id=:quarter_id, status=:status";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // bind values
    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":content", $this->content);
    $stmt->bindParam(":video_link", $this->video_link);
    $stmt->bindParam(":quarter_id", $this->quarter_id);
    $stmt->bindParam(":status", $this->status);
 
    // execute query
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}
    
    // read products
    function read(){
        // select all query
        $query = "SELECT  *  FROM " . $this->table_name . " a
                ORDER BY a.id ASC";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
        
        return $stmt;

    }

    // used when filling up the update product form
    function readById(){
        // query to read single record
        $query = "SELECT * FROM  " . $this->table_name . " a
                WHERE a.quarter_id = ? ";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of product to be updated
        $stmt->bindParam(1, $this->quarter_id);
     
        // execute query
        $stmt->execute();

        $products_arr=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $product_item=array(
            "topic_id" => $row['topic_id'],
            "title" => $row['title'],
            "content" => $row['content'],
            "quarter_id" => $row['quarter_id'],
            "video_link" => $row['video_link'],
            "status" => $row['status'],
            "exercise" => $row['exercise'],
            "quiz" => $row['quiz']
        );
 
        array_push($products_arr, $product_item);
    }
        return $products_arr;
    }

    function readByTopicId(){
        // query to read single record
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " a
                WHERE
                    a.topic_id = ?
                ";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of product to be updated
        $stmt->bindParam(1, $this->topic_id);
     
        // execute query
        $stmt->execute();

        $products_arr=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $product_item=array(
            "topic_id" => $row['topic_id'],
            "title" => $row['title'],
            "content" => $row['content'],
            "quarter_id" => $row['quarter_id'],
            "status" => $row['status'],
            "video_link" => $row['video_link'],
            "exercise" => $row['exercise'],
            "quiz" => $row['quiz'],
        );
 
        array_push($products_arr, $product_item);
    }
        return $products_arr;
    }

    function updateTopic(){
     
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    title = :title,
                    content = :content,
                    video_link = :video_link
                WHERE
                    topic_id = :topic_id";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // bind new values
        $stmt->bindParam(':topic_id', $this->topic_id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':video_link', $this->video_link);
     
        // execute the query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }


    }

    // update the product
    function updateStatus(){
     
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET

                    status = :status
                WHERE
                    topic_id = :topic_id";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->topic_id=htmlspecialchars(strip_tags($this->topic_id));
        $this->status=htmlspecialchars(strip_tags($this->status));

     
        // bind new values
        $stmt->bindParam(':topic_id', $this->topic_id);
        $stmt->bindParam(':status', $this->status);
     
        // execute the query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }


    }

    // delete the product
    function deleteTopic(){
     
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE topic_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // bind id of record to delete
        $stmt->bindParam(1, $this->topic_id);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }


    function getExerciseStatus() {
        // query to read single record

        $query = "SELECT COUNT(q.id) as HASROW, 
                         t.topic_id as topic_id, 
                         t.quarter_id as quarter_id, 
                         t.exercise as exercise_status
                  FROM topics t 
                  LEFT JOIN exercises as q ON q.topicID = t.topic_id 
                  WHERE t.topic_id = ?";
        
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of product to be updated
        $stmt->bindParam(1, $this->topic_id);
     
        // execute query
        $stmt->execute();

        $products_arr=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
     
            $product_item=array(
                "topic_id" => $row['topic_id'],
                "quarter_id" => $row['quarter_id'],
                "exercise_status" => $row['exercise_status'],
                "HASROW" => $row['HASROW'],
            );
     
            array_push($products_arr, $product_item);
        }
        return $products_arr;
    }

    // update the product
    function updateExerciseStatus(){
     
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET

                    exercise = :status
                WHERE
                    topic_id = :topic_id";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->topic_id=htmlspecialchars(strip_tags($this->topic_id));
        $this->status=htmlspecialchars(strip_tags($this->status));

     
        // bind new values
        $stmt->bindParam(':topic_id', $this->topic_id);
        $stmt->bindParam(':status', $this->status);
     
        // execute the query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }


    }

    function getTopicStatus() {
        // query to read single record

        $query = "SELECT t.status as status
                  FROM topics t 
                  WHERE t.topic_id = ?";
        
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of product to be updated
        $stmt->bindParam(1, $this->topic_id);
     
        // execute query
        $stmt->execute();

        $products_arr=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
     
            $product_item=array(
                "topic_id" => $row['topic_id'],
                "status" => $row['status'],
            );
     
            array_push($products_arr, $product_item);
        }
        return $products_arr;
    }


}

?>