<?php
  //Headers for http request that allow anyone to connect to the API
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  //for connection to the database.
  include_once '../../config/Database.php';
  //the food model that defines the queries to the database
  include_once '../../models/Food.php';

  //create a database object to handle the connection
  $database = new Database();
  $db = $database->connect();
  $date = date("Y-m-d");
  $food = new Food($db);
  //GET UserID using the turnary operator '?' aka short if and ':' for else
  //using the superglobal $_GET to obtain the field passed in from the get
  //request.
  $food->userid = isset($_GET['userid']) ? $_GET['userid'] : die();

  //execute the query using the readUserFood function
  $result = $food->read_user_food();

  //check that there are results
  $numRow = $result->rowCount();
  if($numRow > 0){
    //'data' is for the values in the results array
    $food_user_array = array();
    $food_user_array['data'] = array();

    //iterate over the results in the array by fetching the associate array
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
      extract($row);
      $food_user_item = array(
        'foodname' => $foodname,
        'calories' => $calories,
        'carbs' => $carbs,
        'fat' => $fat,
        'fiber' => $fiber,
        'protein' => $protein,
        'datetoday' => $datetoday
      );
      //push the data into the $food_array
      array_push($food_user_array['data'], $food_user_item);
    }
    //turn the array into Json data
    echo json_encode($food_user_array);
  }
  else{
    echo json_encode(
      array( 'message' => 'No Foods Found' )
    );
  }

 ?>
