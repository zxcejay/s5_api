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
$account = $product->readByTopicId();

// create array
// $product_arr = array(
//  			"topic_id" => $product->topic_id,
//             "title" => $product->title,
//             "content" => $product->content,
//             "quarter_id" => $product->quarter_id,
//             "status" => $product->status

// );
 // array_push($account, $product_arr);
// make it json format
print_r(json_encode($account));
?>