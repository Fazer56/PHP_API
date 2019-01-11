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
  //the food model that defines the queries to the database
  include_once '../../models/Nutrition.php';

  $database = new Database();
  $db = $database->connect();
  $nutrition = new Nutrition($db);

  //$nutrition->id;
  //$nutrition->dateCreated;
  //$nutrition->dateUpdated;


  //check that the Createnutrition has been set.
  if(isset($_POST['CreateNutrition'])){
    $nutrition->userid = trim($_POST['UserId']);
    $nutrition->caloriesTarget = trim($_POST['CaloriesTarget']);
    $nutrition->carbsTarget = trim($_POST['CarbsTarget']);
    $nutrition->fatTarget = trim($_POST['FatTarget']);
    $nutrition->fiberTarget = trim($_POST['FiberTarget']);
    $nutrition->proteinTarget = trim($_POST['ProteinTarget']);
    $nutrition->sodiumTarget = trim($_POST['SodiumTarget']);
    $nutrition->calciumTarget = trim($_POST['CalciumTarget']);
    $nutrition->vitaminATarget = trim($_POST['VitaminATarget']);
    $nutrition->vitaminCTarget = trim($_POST['VitaminCTarget']);
    $nutrition->vitaminDTarget = trim($_POST['VitaminDTarget']);

  }

  //create nutrition check that it works
  if($nutrition->createNutrition()){
    echo json_encode(
      array('message' => 'Nutrition Created')
    );
  }
  else{
    echo json_encode(
      array('message' => 'Nutrition Not Created')
    );
  }


  ?>
