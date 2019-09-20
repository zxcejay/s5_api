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
$question=array(); 
// prepare arr objects
$arr = new Questions($db);
 
// set ID property of arr to be edited
$arr->exercise_id = isset($_GET['exercise_id']) ? $_GET['exercise_id'] : die();
 
// read the details of arr to be edited
$question = $arr->getExercise();

print_r(json_encode($question));
?>