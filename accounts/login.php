<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
// header("Access-Control-Allow-Methods: DELETE, HEAD, GET, OPTIONS, POST, PUT");
// header("Access-Control-Allow-Credentials: true");
// header('Content-Type: application/json');
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
// $data = json_decode(file_get_contents('php://input'), true);
// $product->id = isset($_GET['id']) ? $_GET['id'] : die();
// var_dump($data);die();
$username = isset($_GET['username']) ? $_GET['username'] : die();
$password = isset($_GET['password']) ? $_GET['password'] : die();
// print_r(json_encode($data));die();
$product->username = isset($username) ? $username : die();
$product->password = isset($password) ? $password : die();
 
// read the details of product to be edited
$product->readByUserPass();

// create array

if ($product->status == "200") {
	$product_arr = array(
		"id" => $product->id,
		"status" => $product->status,
		"username" => $product->validUsername,
		"password" => $product->validPassword,
	);
	
} else {
	$product_arr = array(
		"status" => $product->status,
	);
}

 array_push($account, $product_arr);
// make it json format
print_r(json_encode($account));
?>