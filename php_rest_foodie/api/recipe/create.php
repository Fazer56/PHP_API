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

  if(isset($_POST['CreateRecipe'])){
    $recipe->id = trim($_POST['Id']);
    $recipe->title = trim($_POST['Title']);
    $recipe->calories = trim($_POST['Calories']);
    $recipe->ingredients = trim($_POST['Ingredients']);
    $recipe->healthLabels = trim($_POST['HealthLabels']);
    $recipe->dietLabels = trim($_POST['DietLabels']);
    $recipe->imageUrl = trim($_POST['ImageUrl']);
    $recipe->recipeUrl = trim($_POST['RecipeUrl']);
    $recipe->carbs = trim($_POST['Carbs']);
    $recipe->fat = trim($_POST['Fat']);
    $recipe->protein = trim($_POST['Protein']);
    $recipe->fiber = trim($_POST['Fiber']);
    $recipe->calcium = trim($_POST['Calcium']);
    $recipe->sodium = trim($_POST['Sodium']);
    $recipe->vitaminA = trim($_POST['VitaminA']);
    $recipe->vitaminC = trim($_POST['VitaminC']);
    $recipe->vitaminD = trim($_POST['VitaminD']);
    $recipe->serves = trim($_POST['Serves']);
    $recipe->totalWeight = trim($_POST['TotalWeight']);

  }

  if($recipe->create()){
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

/*
Id:http://www.edamam.com/ontologies/edamam.owl#recipe_239eb2be2c3485cd5babbffe4f23764e
Title:Thai Chicken Curry
ImageUrl:https://www.edamam.com/web-img/7f1/7f1b8c2547e778e2e409ddea1befdebf.jpg
RecipeUrl:http://www.bbcgoodfood.com/recipes/1788/thai-chicken-curry
Serves:4
DietLabels:Low-Carb
HealthLabels:Sugar-Conscious,Peanut-Free,Tree-Nut-Free,Alcohol-Free
Ingredients:3-4 tsp red thai curry paste, 1.0 tsp sugar, brown is best, 1.0 tbsp fish sauce,1.0 tbsp vegetable oil,1 stalk lemon grass,4 boneless and skinless chicken breasts, cut into bite-size pieces,400 ml can coconut milk,4 freeze-dried kaffir lime leaves,20.0g pack fresh coriander,2 shallots , or 1 small onion
Calories:2339.16
TotalWeight:1684.38
Fat:125.56
Carbs:45.02
Fiber:5.76
Protein:258.66
Calcium:240.64
VitaminA:167.17
VitaminC:22.97
VitaminD:0.0
Sodium:2072.98
CreateRecipe:true


INSERT INTO recipes(Id,Title, ImageUrl, RecipeUrl, Serves, DietLabels, HealthLabels, Ingredients, Calories, TotalWeight, Fat, Carbs, Fiber, Protein, Calcium, VitaminA, VitaminC, VitaminD, Sodium) VALUES('http://www.edamam.com/ontologies/edamam.owl#recipe_239eb2be2c3485cd5babbffe4f23764e','Thai Chicken Curry','https://www.edamam.com/web-img/7f1/7f1b8c2547e778e2e409ddea1befdebf.jpg','http://www.bbcgoodfood.com/recipes/1788/thai-chicken-curry',4,'Low-Carb','Sugar-Conscious,Peanut-Free,Tree-Nut-Free,Alcohol-Free','3-4 tsp red thai curry paste, 1.0 tsp sugar, brown is best, 1.0 tbsp fish sauce,1.0 tbsp vegetable oil,1 stalk lemon grass,4 boneless and skinless chicken breasts, cut into bite-size pieces,400 ml can coconut milk,4 freeze-dried kaffir lime leaves,20.0g pack fresh coriander,2 shallots , or 1 small onion',2339.16,1684.38,125.56,45.02,5.76,258.66,240.64,167.17,22.97,0.0,2072.98);


*/

  ?>
