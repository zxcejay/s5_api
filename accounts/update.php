<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/accounts.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Accounts($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of product to be edited
$product->id = $data->id;
 
// set product property values

$product->id = $data->id;
$product->firstname = $data->firstname;
$product->middlename = $data->middlename;
$product->lastname = $data->lastname;
$product->birthday = $data->birthday;
$product->section = $data->section;
$product->guardian = $data->guardian;
$product->address = $data->address;
$product->contact_number = $data->contact_number;
$product->username = $data->username;
$product->password = $data->password;
 
// update the product
if($product->update()){
    echo '{';
        echo '"message": "Account was updated."';
    echo '}';
}
 
// if unable to update the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to update product."';
    echo '}';
}
?>