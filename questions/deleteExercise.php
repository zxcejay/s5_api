<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/question.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare exercise object
$product = new Questions($db);
 
// get exercise id
// $data = (file_get_contents("php://input"));
$data = isset($_GET['exercise_id']) ? $_GET['exercise_id'] : die();
 
// set exercise id to be deleted
$product->exercise_id = $data;
 
// delete the exercise
if($product->deleteExercise()){
    echo '{';
        echo '"message": "Exercise was deleted."';
    echo '}';
}
 
// if unable to delete the exercise
else{
    echo '{';
        echo '"message": "Unable to delete exercise."';
    echo '}';
}
?>