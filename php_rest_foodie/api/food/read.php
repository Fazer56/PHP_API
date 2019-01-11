<?php
  ///Headers for http request allow anyone to connect
  header('Access-Contol-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Food.php';

  //create a database object
  $database = new Database();
  $db = $database->connect();
  $date = date("Y-m-d");
  //create a Food object
  $food = new Food($db);

  //GET UserID using turnary operator '?' aka short if ':' for else
  //and superglobal $_GET. if its not there kill
  //$food->userid = isset($_GET['userid']) ? $_GET['userid'] : die();

  //food eaten query
  $result = $food->read();
  //get row count
  $numRow = $result->rowCount();

  //check for foods
  if($numRow > 0){
    //'data' is for the values in the array
    $food_array = array();
    $food_array['data'] = array();

    //iterate over the ruselts and fetch the associative array
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
      extract($row);

      $food_item = array(
        'foodname' => $foodname,
        'calories' => $calories,
        'carbs' => $carbs,
        'fat' => $fat,
        'fiber' => $fiber
      );
      //push the to data in the array
      array_push($food_array['data'], $food_item);
    }
    //turn the array to Json data
    echo json_encode($food_array);

  }
  else {
      //no foods
      echo json_encode(
        array('message' => 'No Foods Found' )
      );
  }
 ?>
