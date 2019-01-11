<?php

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Authorization, x-Requested-With');
  header('Access-Control-Allow-Methods: POST');

  include_once '../../config/Database.php';
  include_once '../../models/UserTb.php';

  $database = new Database();
  $db = $database->connect();
  $user = new User($db);

  //get the values posted to the API
  if(isset($_POST['RegisterForm'])){
    $user->email = trim($_POST['Email']);
    $user->password = trim($_POST['Password']);
    $user->firstname = trim($_POST['FirstName']);
    $user->surname = trim($_POST['Surname']);
    $user->gender = trim($_POST['Gender']);
    $user->birth_Date = trim($_POST['BirthDate']);
    $user->weight = trim($_POST['WeightKg']);
    $user->height = trim($_POST['HeightCm']);
    $user->active = trim($_POST['ActiveLevel']);
    $user->password = md5($user->password);
  }

  if($user->checkEmail()){
    echo json_encode(
      array("message" => "Email is Registered")
    );
  }
  else if($user->register()){
      echo json_encode(
        array("message" => "Successfully Registered",
               "Id" => $user->id,
               "Gender" => $user->gender,
               "WeightKg" => $user->weight,
               "HeightCm" => $user->height,
               "ActiveLevel" => $user->active,
               "Age" => $user->age

            )
      );
    }
    else{
      echo json_encode(
        array("message" => "Registration error")
      );
    }



 ?>
