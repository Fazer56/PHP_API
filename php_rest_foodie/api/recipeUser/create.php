<?php
//INSERT INTO NUTRITION TABLE
//Headers for http request that allow anyone to connect to the API
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
//For post requests
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Acccess-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


//for connection to the database.
include_once '../../config/Database.php';
//the recipeUser model that defines the queries to the database
include_once '../../models/RecipeUser.php';

$database = new Database();
$db = $database->connect();
$recUser = new RecipeUser($db);

//check that the Createnutrition has been set.
if(isset($_POST['UserId']) && isset($_POST['RecipeId'])){
  $recUser->userId = trim($_POST['UserId']);
  $recUser->recipeId = trim($_POST['RecipeId']);
}

if($recUser->create()){
  echo json_encode(array("message" => "Created"));
}
else{
  echo json_encode(array("message" => "Not Created"));
}


?>
