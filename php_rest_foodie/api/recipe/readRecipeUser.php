<?php
  //Headers for http request that allow anyone to connect to the API
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  //For post requests
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Authorization, x-Requested-With');

  //for connection to the database.
  include_once '../../config/Database.php';
  //the recipe model that defines the queries to the database
  include_once '../../models/Recipe.php';

  //create a database object to handle the connection
  $database = new Database();
  $db = $database->connect();

  $recipe = new Recipe($db);

  if(isset($_POST['UserId'])){
    $recipe->userId = trim($_POST['UserId']);
  }

  $result = $recipe->read_user_recipe();

  $numRow = $result->rowCount();

  if($numRow >0){
    $recipeArr = array();
    $recipeArr['data'] = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
      extract($row);
      $id = $row['Id'];
      $calories = $row['Calories'];
      $carbs = $row['Carbs'];
      $fat = $row['Fat'];
      $protein = $row['Protein'];
      $fiber = $row['Fiber'];
      $calcium = $row['Calcium'];
      $sodium = $row['Sodium'];
      $vitaminA = $row['VitaminA'];
      $vitaminD = $row['VitaminD'];
      $vitaminC = $row['VitaminC'];
      $title = $row['Title'];
      $healthLabels = $row['HealthLabels'];
      $dietLabels = $row['DietLabels'];
      $serves = $row['Serves'];
      $ingredients = $row['Ingredients'];
      $totalWeight = $row['TotalWeight'];
      $recipeUrl = $row['RecipeUrl'];
      $imageUrl = $row['ImageUrl'];

      $recipeItem = array(
        'Calories' => $calories,
        'Carbs' => $carbs,
        'Fat' => $fat,
        'Protein' => $protein,
        'Sodium' => $sodium,
        'Fiber' => $fiber,
        'Calcium' => $calcium,
        'VitaminA' => $vitaminA,
        'VitaminC' => $vitaminC,
        'VitaminD' => $vitaminD,
        'Title' => $title,
        'HealthLabels' =>  $healthLabels,
        'DietLabels' =>  $dietLabels,
        'Serves' =>  $serves,
        'Ingredients' => $ingredients,
        'TotalWeight' => $totalWeight,
        'RecipeUrl' => $recipeUrl,
        'ImageUrl' => $imageUrl,
        'Id' => $id,
        
      );
      array_push($recipeArr['data'], $recipeItem);
    }
    echo json_encode($recipeArr);
  }
  else{
      echo json_encode(
        array(
          "message" => "Error"
      ));
  }

  ?>
