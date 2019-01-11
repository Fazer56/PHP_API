<?php
  class Food{
    private $connection;
    private $table = 'foods';

    public $name;
    public $calories;
    public $carbs;
    public $fat;
    public $fiber;
    public $protein;
    public $userId;
    public $calcium;
    public $vitaminA;
    public $vitaminC;
    public $vitaminD;
    public $quantity;
    public $weightGram;
    public $sodium;
    public $dateCreated;
    public $dateUpdated;
    public $datetoday;


    //constructor
    public function __construct($dbConn){
      $this->connection = $dbConn;

    }

    // GET Foods
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

    //GET USER Foods
    public function read_user_food(){

    /*  SELECT SUM(f.Calories) AS CaloriesTotal,
SUM(f.Carbs) AS CarbsTotal, SUM(f.Fat) AS FatTotal,
SUM(f.Protein) AS ProteinTotal, SUM(f.Fiber) AS FiberTotal,
SUM(f.Calcium) AS CalciumTotal, SUM(f.Sodium) AS SodiumTotal, SUM(f.VitaminA) AS VitaminATotal,
SUM(f.VitaminC) AS VitaminCTotal, SUM(f.VitaminD) AS VitaminDTotal
FROM foods AS f
JOIN users AS u ON f.UserId = u.Id
WHERE u.Id = 1 AND f.DateCreated >= '2018-11-27 00:00:00' AND f.DateCreated <= '2018-11-27 23:59:59';*/

        $query = 'SELECT f.Name,f.UserId,f.Calories,
                  f.Carbs,f.Fat,f.Protein,f.Fiber,f.Calcium,Sodium,VitaminA,VitaminC,VitaminD,
                  Quantity,WeightGram
               FROM ' . $this->table . ' f INNER JOIN recipeuser r
               ON f.foodid = r.foodid INNER JOIN usertb u
               ON r.userid = u.userid INNER JOIN nutrfood nf
               ON f.foodid = nf.foodid
               WHERE u.userid = ?
               AND nf.datetoday = \' ' . $date1 . ' \' ';

       //prepared Statemment
       $stmt = $this->connection->prepare($query);

        //binded with the user id using positional parameter
       $stmt->bindParam(1,$this->userid);

       //Execute $query
       $stmt->execute();

       return $stmt;

      // $row = $stmt->fetch(PDO::FETCH_ASSOC);

    }


    // POST to Food
    public function create(){
      $query = 'INSERT INTO ' . $this->table . '(Name,UserId,Calories,
                Carbs,Fat,Protein,Fiber,Calcium,Sodium,VitaminA,VitaminC,VitaminD,
                Quantity,WeightGram) VALUES(:Name,:UserId,:Calories,
                :Carbs,:Fat,:Protein,:Fiber,:Calcium,:Sodium,:VitaminA,:VitaminC,:VitaminD,
                :Quantity,:WeightGram)
              ';

              $stmt = $this->connection->prepare($query);

              //clean the data that is posted
              $this->name = htmlspecialchars(strip_tags($this->name));
              $this->calories = htmlspecialchars(strip_tags($this->calories));
              $this->carbs = htmlspecialchars(strip_tags($this->carbs));
              $this->fat = htmlspecialchars(strip_tags($this->fat));
              $this->protein = htmlspecialchars(strip_tags($this->protein));
              $this->fiber = htmlspecialchars(strip_tags($this->fiber));
              $this->calcium = htmlspecialchars(strip_tags($this->calcium));
              $this->vitaminA = htmlspecialchars(strip_tags($this->vitaminA));
              $this->vitaminC = htmlspecialchars(strip_tags($this->vitaminC));
              $this->vitaminD = htmlspecialchars(strip_tags($this->vitaminD));
              $this->quantity = htmlspecialchars(strip_tags($this->quantity));
              $this->sodium = htmlspecialchars(strip_tags($this->sodium));
              $this->weightGram = htmlspecialchars(strip_tags($this->weightGram));
              $this->userId = htmlspecialchars(strip_tags($this->userId));


              //Bind the data using named parameters that are posted to the api
              //from the client
              $stmt->bindParam(':Name', $this->name);
              $stmt->bindParam(':Calories', $this->calories);
              $stmt->bindParam(':Carbs', $this->carbs);
              $stmt->bindParam(':Fat', $this->fat);
              $stmt->bindParam(':Protein', $this->protein);
              $stmt->bindParam(':Fiber', $this->fiber);
              $stmt->bindParam(':Calcium', $this->calcium);
              $stmt->bindParam(':VitaminA', $this->vitaminA);
              $stmt->bindParam(':VitaminC', $this->vitaminC);
              $stmt->bindParam(':VitaminD', $this->vitaminD);
              $stmt->bindParam(':Sodium', $this->sodium);
              $stmt->bindParam(':UserId', $this->userId);
              $stmt->bindParam(':Quantity', $this->quantity);
              $stmt->bindParam(':WeightGram', $this->weightGram);

              //execute the query
              if($stmt->execute()){
                return true;
              }
              //print error if something goes wrong cam be seen in the raw
              //tab on postman
              //printf("Error: %s. \n", $stmt->error;

              return false;
    }

    //calculate user's consumed nutrition of foods
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
