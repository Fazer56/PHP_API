<?php
  //INSERT INTO NUTRITION TABLE
  //Headers for http request that allow anyone to connect to the API
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  //For post requests
  header('Access-Control-Allow-Methods: GET');
  header('Access-Control-Allow-Headers: Acccess-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


  //for connection to the database.
  include_once '../../config/Database.php';
  //the food model that defines the queries to the database
  include_once '../../models/Nutrition.php';

  $database = new Database();
  $db = $database->connect();
  $nutrition = new Nutrition($db);
  $date = date("Y-m-d");

  //$nutrition->id;
  //$nutrition->dateCreated;
  //$nutrition->dateUpdated;

  //check that the Createnutrition has been set.
  if(isset($_POST['UserId']) && isset($_POST['DateCreated'])){
    $nutrition->userid = trim($_POST['UserId']);
    $nutrition->dateCreated = trim("%$_POST[DateCreated]%");
  }


  $nutrition->readToday();

  ?>
