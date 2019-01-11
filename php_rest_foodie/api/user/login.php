<?php
  //Headers for http request that allow anyone to connect to the API
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Authorization, x-Requested-With');
  header('Access-Control-Allow-Methods: POST');
  //for connection to the database.
  include_once '../../config/Database.php';
  //the food model that defines the queries to the database
  include_once '../../models/UserTb.php';

  //create a database object to handle the connection
  $database = new Database();
  $db = $database->connect();
  $user = new User($db);

  //GET the raw login data
  //$logindata = json_decode(file_get_contents("php://input"));
// $user->email = isset($_GET['Email']) ? $_GET['Email'] : die();
//  $user->password = isset($_GET['Password']) ? $_GET['Password'] : die();
  if(isset($_POST['LoginForm']) && isset($_POST['Email']) && isset($_POST['Password']) ){
    $user->email = trim($_POST['Email']);
    $user->password = trim($_POST['Password']);
    //encrypt the password
    $user->password = md5($user->password);
    //catch exceptions
    //USE POST FOR LOGIN
    $user->login();

    if($user->id != null){
      $user_arr = array(
        'message' => 'Granted',
        'Id' => $user->id,
        'FirstName' =>  $user->firstname,
        'Surname' => $user->surname,
        'Email' => $user->email,
        'Age' => $user->age,
        'Gender' => $user->gender,
        'WeightKg' => $user->weight,
        'HeightCm' => $user->height,
        'ActiveLevel' => $user->active

      );
      echo json_encode(array($user_arr));
    }

  }
  else{
    echo json_encode(array('message' => 'Error'));
  }



?>
