<?php
  //Headers for http request that allow anyone to connect to the API
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  //For post requests
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Authorization, x-Requested-With');

  //for connection to the database.
  include_once '../../config/Database.php';
  //the food model that defines the queries to the database
  include_once '../../models/Food.php';

  //create a database object to handle the connection
  $database = new Database();
  $db = $database->connect();

  $food = new Food($db);

  if(isset($_POST['CreateFood'])){
    $food->name = trim($_POST['Name']);
    $food->userId = trim($_POST['UserId']);
    $food->calories = trim($_POST['Calories']);
    $food->carbs = trim($_POST['Carbs']);
    $food->fat = trim($_POST['Fat']);
    $food->protein = trim($_POST['Protein']);
    $food->fiber = trim($_POST['Fiber']);
    $food->calcium = trim($_POST['Calcium']);
    $food->sodium = trim($_POST['Sodium']);
    $food->vitaminA = trim($_POST['VitaminA']);
    $food->vitaminC = trim($_POST['VitaminC']);
    $food->vitaminD = trim($_POST['VitaminD']);
    $food->quantity = trim($_POST['Quantity']);
    $food->weightGram = trim($_POST['WeightGram']);

  }

  if($food->create()){
    echo json_encode(
      array(
        "message" => "Created"
    ));
  }
  else{
      echo json_encode(
        array(
          "message" => "Error"
      ));
  }


  ?>
