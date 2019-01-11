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

  if(isset($_POST['UserId']) && isset($_POST['DateCreated'])){
    $food->userId = trim($_POST['UserId']);
    $food->dateCreated = trim("%$_POST[DateCreated]%");
  }

  $food->consumed_user_food();


  ?>
