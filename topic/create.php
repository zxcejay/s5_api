<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/topic.php';
 
$database = new Database();
$db = $database->getConnection();
 
$product = new Topic($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$product->title = $data->title;
$product->content = $data->content;
$product->video_link = $data->video_link;
$product->quarter_id = $data->quarter_id;
$product->status = $data->status;
 
// create the product
if($product->create()){
    echo '{';
        echo '"status":"200",';
        echo '"message": "Topic was created."';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create topic."';
    echo '}';
}


?>