<?php
class Questions{
 
    // database connection and table name
    private $conn;
    // private $table_name = "questions";
 
    // object properties
    public $topic_id;
    public $title;
    public $content;
    public $video_link;
    public $quarter_id;
    public $status;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // Quizzes APIs
    function getQuizzes() {
        // query to read single record
        $query = "SELECT q.quizID as quizID,
                                 q.id as id,
                     q.quizBody as question,
                                  c._a as a,
                                  c._b as b,
                                  c._c as c,
                                  c._d as d,
                          c.answer as answer
                  FROM quizzes q 
                  LEFT JOIN choices c ON q.quizID = c.referenceID
                  WHERE q.quarterID = ".$this->quarter_id." ORDER BY q.id
                ";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();

        $products_arr=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
     
            $product_item=array(
                "quarter_id" => $this->quarter_id,
                "quiz_id" => $row['quizID'],
                "quizQuestion" => $row['question'],
                "a" => $row['a'],
                "b" => $row['b'],
                "c" => $row['c'],
                "d" => $row['d'],
                "answer" => $row['answer']
            );
     
            array_push($products_arr, $product_item);
        }
        return $products_arr;
    }

    function getQuiz() {
        // query to read single record
        $query = "SELECT q.quizID as quizID,
                                 q.id as id,
                  q.quarterID as quarter_id,
                     q.quizBody as question,
                                  c._a as a,
                                  c._b as b,
                                  c._c as c,
                                  c._d as d,
                          c.answer as answer
                  FROM quizzes q 
                  LEFT JOIN choices c ON q.quizID = c.referenceID
                  WHERE q.quizID = '".$this->quiz_id."'
                ";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();

        $products_arr=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
     
            $product_item=array(
                "quarter_id" => $row['quarter_id'],
                "quiz_id" => $row['quizID'],
                "quizQuestion" => $row['question'],
                "a" => $row['a'],
                "b" => $row['b'],
                "c" => $row['c'],
                "d" => $row['d'],
                "answer" => $row['answer']
            );
     
            array_push($products_arr, $product_item);
        }
        return $products_arr;
    }

    function deleteQuiz(){
        $query = "DELETE FROM quizzes
                  WHERE quizID = '".$this->quiz_id."'";
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();

        $query = "DELETE FROM choices
                  WHERE referenceID = '".$this->quiz_id."'";
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();

        return true;
    }
    // End Quizzes APIs

    // Exercise APIs
    function getExercises(){
        // query to read single record
        $query = "SELECT e.id as id,
                         e.exerciseID as exerciseID,
                         e.exerciseBody as question,
                         c.answer as answer 
                  FROM exercises e 
                  LEFT JOIN choices c ON e.exerciseID = c.referenceID
                  WHERE e.quarterID = ".$this->quarter_id." AND e.topicID = ".$this->topic_id."  ORDER BY e.id
                ";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();

        $products_arr=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
     
            $product_item=array(
                "quarter_id" => $this->quarter_id,
                "topic_id" => $this->topic_id,
                "exercise_id" => $row['exerciseID'],
                "exerciseQuestion" => $row['question'],
                "answer" => $row['answer']
            );
     
            array_push($products_arr, $product_item);
        }
        return $products_arr;
    }

    function getExercise(){
        // query to read single record
        $query = "SELECT e.id as id,
                         e.exerciseID as exerciseID,
                         e.quarterID as quarterID,
                         e.topicID as topicID,
                         e.exerciseBody as question,
                         c.answer as answer 
                  FROM exercises e 
                  LEFT JOIN choices c ON e.exerciseID = c.referenceID
                  WHERE e.exerciseID = '".$this->exercise_id."'
                ";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();

        $products_arr=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
     
            $product_item=array(
                "quarter_id" => $row['quarterID'],
                "topic_id" => $row['topicID'],
                "exercise_id" => $row['exerciseID'],
                "exerciseQuestion" => $row['question'],
                "answer" => $row['answer']
            );
     
            array_push($products_arr, $product_item);
        }
        return $products_arr;
    }

    function deleteExercise(){
        $query = "DELETE FROM exercises
                  WHERE exerciseID = '".$this->exercise_id."'";
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();

        $query = "DELETE FROM choices
                  WHERE referenceID = '".$this->exercise_id."'";
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();

        return true;
    }

    // End Exercise APIs

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

}

?>