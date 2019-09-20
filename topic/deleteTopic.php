<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/topic.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Topic($db);
 
// get product id
// $data = (file_get_contents("php://input"));
$data = isset($_GET['topic_id']) ? $_GET['topic_id'] : die();
 
// set product id to be deleted
$product->topic_id = $data;
 
// delete the product
if($product->deleteTopic()){
    echo '{';
        echo '"message": "Topic was deleted."';
    echo '}';
}
 
// if unable to delete the product
else{
    echo '{';
        echo '"message": "Unable to delete object."';
    echo '}';
}
?>