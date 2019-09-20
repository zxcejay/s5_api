<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/accounts.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
$account=array(); 
// prepare product object
$product = new Accounts($db);
 
// set ID property of product to be edited
$product->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$product->readById();

// create array
$product_arr = array(
 			"id" => $product->id,
            "firstname" => $product->firstname,
            "middlename" => $product->middlename,
            "lastname" => $product->lastname,
            "birthday" => $product->birthday,
            "section" => $product->section,
            "guardian" => $product->guardian,
            "address" => $product->address,
            "contact_number" => $product->contact_number,
            "username" => $product->username,
            "password" => $product->password,

);
 array_push($account, $product_arr);
// make it json format
print_r(json_encode($account));
?>