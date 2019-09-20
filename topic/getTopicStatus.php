<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/topic.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
$account=array(); 
// prepare product object
$product = new Topic($db);
 
// set ID property of product to be edited
$product->topic_id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$account = $product->getTopicStatus();

print_r(json_encode($account));
?>