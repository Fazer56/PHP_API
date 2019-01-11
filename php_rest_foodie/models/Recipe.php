<?php
  class Recipe{
    private $connection;
    private $table = 'recipes';

    public $id;
    public $title;
    public $ingedients;
    public $calories;
    public $carbs;
    public $fat;
    public $fiber;
    public $protein;
    public $calcium;
    public $vitaminA;
    public $vitaminC;
    public $vitaminD;
    public $serves;
    public $totalWeight;
    public $sodium;
    public $dateCreated;
    public $healthLabels;
    public $dietLabels;
    public $imageUrl;
    public $recipeUrl;
    public $userId;


    //constructor
    public function __construct($dbConn){
      $this->connection = $dbConn;

    }

    // GET Recipes
    public function read(){
      $query = 'SELECT f.foodname, f.calories, f.carbs, f.fat, f.fiber, f.protein
                FROM ' . $this->table . ' f
              ';
      //prepared Statemment
       $stmt = $this->connection->prepare($query);
      //Execute $query
      $stmt->execute();

      return $stmt;
    }

    //GET User Recipe Foods
    public function read_user_recipe(){

        $query = 'SELECT r.Title,r.Calories, r.Id,
                  r.Carbs,r.Fat,r.Protein,r.Fiber,r.Calcium,r.Sodium,
                  r.VitaminA,r.VitaminC,r.VitaminD, r.HealthLabels,r.DietLabels,
                  r.Serves,r.TotalWeight, r.Ingredients, r.RecipeUrl,
                  r.ImageUrl
                 FROM ' . $this->table . ' r INNER JOIN recipeuser ru
                 ON r.Id = ru.RecipeId INNER JOIN users u
                 ON ru.UserId = u.Id
                 WHERE u.Id = :UserId
                 ';

       //prepared Statemment
       $stmt = $this->connection->prepare($query);

       //$this->userId = htmlspecialchars(strip_tags($this->userId));
        //binded with the user id using positional parameter
       $stmt->bindParam(':UserId',$this->userId);

       //Execute $query
       $stmt->execute();

       return $stmt;

      // $row = $stmt->fetch(PDO::FETCH_ASSOC);

    }

    // POST to Recipes
    public function create(){
      $query = 'INSERT INTO ' . $this->table . '(Id,Title,Calories,Ingredients,
                HealthLabels, DietLabels, ImageUrl, RecipeUrl, TotalWeight, Serves,
                Carbs,Fat,Protein,Fiber,Calcium,Sodium,VitaminA,VitaminC,VitaminD)
                VALUES(:Id,:Title,:Calories,:Ingredients,
                :HealthLabels, :DietLabels, :ImageUrl, :RecipeUrl, :TotalWeight, :Serves,
                :Carbs,:Fat,:Protein,:Fiber,:Calcium,:Sodium,:VitaminA,:VitaminC,:VitaminD
                )
              ';

              $stmt = $this->connection->prepare($query);

              //clean the data that is posted
              $this->id = htmlspecialchars(strip_tags($this->id));
              $this->title = htmlspecialchars(strip_tags($this->title));
              $this->ingredients = htmlspecialchars(strip_tags($this->ingredients));
              $this->healthLabels = htmlspecialchars(strip_tags($this->healthLabels));
              $this->dietLabels = htmlspecialchars(strip_tags($this->dietLabels));
              $this->imageUrl = htmlspecialchars(strip_tags($this->imageUrl));
              $this->recipeUrl = htmlspecialchars(strip_tags($this->recipeUrl));
              $this->calories = htmlspecialchars(strip_tags($this->calories));
              $this->carbs = htmlspecialchars(strip_tags($this->carbs));
              $this->fat = htmlspecialchars(strip_tags($this->fat));
              $this->protein = htmlspecialchars(strip_tags($this->protein));
              $this->fiber = htmlspecialchars(strip_tags($this->fiber));
              $this->calcium = htmlspecialchars(strip_tags($this->calcium));
              $this->vitaminA = htmlspecialchars(strip_tags($this->vitaminA));
              $this->vitaminC = htmlspecialchars(strip_tags($this->vitaminC));
              $this->vitaminD = htmlspecialchars(strip_tags($this->vitaminD));
              $this->serves = htmlspecialchars(strip_tags($this->serves));
              $this->sodium = htmlspecialchars(strip_tags($this->sodium));
              $this->totalWeight = htmlspecialchars(strip_tags($this->totalWeight));

              //Bind the data using named parameters that are posted to the api
              //from the client
              $stmt->bindParam(':Id', $this->id);
              $stmt->bindParam(':Title', $this->title);
              $stmt->bindParam(':Calories', $this->calories);
              $stmt->bindParam(':Ingredients', $this->ingredients);
              $stmt->bindParam(':HealthLabels', $this->healthLabels);
              $stmt->bindParam(':DietLabels', $this->dietLabels);
              $stmt->bindParam(':ImageUrl', $this->imageUrl);
              $stmt->bindParam(':RecipeUrl', $this->recipeUrl);
              $stmt->bindParam(':Carbs', $this->carbs);
              $stmt->bindParam(':Fat', $this->fat);
              $stmt->bindParam(':Protein', $this->protein);
              $stmt->bindParam(':Fiber', $this->fiber);
              $stmt->bindParam(':Calcium', $this->calcium);
              $stmt->bindParam(':VitaminA', $this->vitaminA);
              $stmt->bindParam(':VitaminC', $this->vitaminC);
              $stmt->bindParam(':VitaminD', $this->vitaminD);
              $stmt->bindParam(':Sodium', $this->sodium);
              $stmt->bindParam(':Serves', $this->serves);
              $stmt->bindParam(':TotalWeight', $this->totalWeight);

              //execute the query
              if($stmt->execute()){
                return true;
              }
              //print error if something goes wrong cam be seen in the raw
              //tab on postman
              //printf("Error: %s. \n", $stmt->error);

              return false;
    }



    //return the recipes the user has saved
    public function consumed_user_food(){

        $query = 'SELECT SUM(f.Calories) AS Calories,
                  SUM(f.Carbs) AS Carbs, SUM(f.Fat) AS Fat,
                  SUM(f.Protein) AS Protein, SUM(f.Fiber) AS Fiber,
                  SUM(f.Calcium) AS Calcium, SUM(f.Sodium) AS Sodium,
                  SUM(f.VitaminA) AS VitaminA, SUM(f.VitaminC) AS VitaminC,
                  SUM(f.VitaminD) AS VitaminD
                  FROM ' . $this->table . ' AS f
                  JOIN users AS u ON f.UserId = u.Id
                  WHERE u.Id = :Id AND f.DateCreated LIKE :DateCreated';

       //prepared Statemment
       $stmt = $this->connection->prepare($query);

        //binded with the user id using positional parameter
       $stmt->bindParam(':Id', $this->userId);
       $stmt->bindParam(':DateCreated', $this->dateCreated);

       //Execute $query
       $stmt->execute();

       if($row = $stmt->fetch(PDO::FETCH_ASSOC)){

         $this->calories = $row['Calories'];
         $this->carbs = $row['Carbs'];
         $this->fat = $row['Fat'];
         $this->protein = $row['Protein'];
         $this->fiber = $row['Fiber'];
         $this->calcium = $row['Calcium'];
         $this->sodium = $row['Sodium'];
         $this->vitaminA = $row['VitaminA'];
         $this->vitaminD = $row['VitaminD'];
         $this->vitaminC = $row['VitaminC'];


         $food_item = array(
           'message' => 'Consumed',
           'Calories' => $this->calories,
           'Carbs' => $this->carbs,
           'Fat' => $this->fat,
           'Protein' => $this->protein,
           'Sodium' => $this->sodium,
           'Fiber' => $this->fiber,
           'Calcium' => $this->calcium,
           'VitaminA' => $this->vitaminA,
           'VitaminC' => $this->vitaminC,
           'VitaminD' => $this->vitaminD
         );

         echo json_encode( $food_item);
       }
       else{
         echo json_encode(
           array('message' => 'No Foods Consumed')
         );
       }


      // $row = $stmt->fetch(PDO::FETCH_ASSOC);

    }


  }

 ?>
