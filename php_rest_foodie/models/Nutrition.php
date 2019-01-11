
<?php
    class Nutrition{
      //database conneciton
      private $connection;
      private $table = 'nutritions';
      private $date;

      public $id;
      public $userid;
      public $caloriesTarget;
      public $carbsTarget;
      public $fatTarget;
      public $proteinTarget;
      public $fiberTarget;
      public $sodiumTarget;
      public $calciumTarget;
      public $vitaminDTarget;
      public $vitaminCTarget;
      public $vitaminATarget;
      public $dateCreated;
      public $dateUpdated;

      //__constructor
      public function __construct($dbCon){
        $this->connection = $dbCon;
      }
      //GET user nutrition
      public function read(){
        //query to get the users nutritional information for that day.
        $query = 'SELECT n.UserId, n.Id, n.CaloriesTarget, n.CarbsTarget,
                  n.ProteinTarget, n.FiberTarget, n.FatTarget, n.SodiumTarget,
                  n.CalciumTarget, n.VitaminATarget, n.VitaminDTarget, n.VitaminCTarget,
                  n.DateCreated, n.DateUpdated FROM ' . $this->table . ' n
                  JOIN users u ON n.UserId = u.Id
                  WHERE u.Id = :Id
                  ORDER BY n.DateCreated ASC;
                  ';

                /*  'SELECT
                            n.DateCreated, n.CaloriesTarget,n.CarbsTarget,n.FatTarget,n.FiberTarget
                            FROM ' . $this->table . ' n
                            JOIN users u ON n.UserId = u.:Id
                            WHERE n.DateCreated like  %' . $this->date . '%
                            ORDER BY DateCreated ASC
                            ';*/
            $stmt = $this->connection->prepare($query);

            $stmt->bindParam(':Id', $this->userid);

            $stmt->execute();

            $numRow = $stmt->rowCount();

            if($numRow > 0){

                $nutritionArr = array();
                //$nutritionArr['data'] = array();
                  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $this->userid = $row['UserId'];
                    $this->caloriesTarget = $row['CaloriesTarget'];
                    $this->carbsTarget = $row['CarbsTarget'];
                    $this->fatTarget = $row['FatTarget'];
                    $this->proteinTarget = $row['ProteinTarget'];
                    $this->fiberTarget = $row['FiberTarget'];
                    $this->dateCreated = $row['DateCreated'];
                    $this->dateUpdated = $row['DateUpdated'];
                    $this->calciumTarget = $row['CalciumTarget'];
                    $this->sodiumTarget = $row['SodiumTarget'];
                    $this->vitaminATarget = $row['VitaminATarget'];
                    $this->vitaminDTarget = $row['VitaminDTarget'];
                    $this->vitaminCTarget = $row['VitaminCTarget'];

                      $nutr_item = array(
                        'UserId' => $this->userid,
                        'CaloriesTarget' => $this->caloriesTarget,
                        'CarbsTarget' => $this->carbsTarget,
                        'FatTarget' => $this->fatTarget,
                        'ProteinTarget' => $this->proteinTarget,
                        'FiberTarget' => $this->fiberTarget,
                        'SodiumTarget' => $this->sodiumTarget,
                        'CalciumTarget' => $this->calciumTarget,
                        'VitaminATarget' => $this->vitaminATarget,
                        'VitaminCTarget' => $this->vitaminCTarget,
                        'VitaminDTarget' => $this->vitaminDTarget,
                        'DateCreated' => $this->dateCreated,
                        'DateUpdated' => $this->dateUpdated
                      );
                      //push the to data in the array
                      array_push($nutritionArr, $nutr_item);
                    }
                    echo json_encode($nutritionArr);
            }
            else{
              echo json_encode(
                array('message' => 'No Nutrition')
              );
            }

  }

      public function readToday(){
        $query = 'SELECT n.UserId, n.Id, n.CaloriesTarget, n.CarbsTarget,
                  n.ProteinTarget, n.FiberTarget, n.FatTarget, n.SodiumTarget,
                  n.CalciumTarget, n.VitaminATarget, n.VitaminDTarget, n.VitaminCTarget,
                  n.DateCreated, n.DateUpdated FROM ' . $this->table . ' n
                  JOIN users u ON n.UserId = u.Id
                  WHERE u.Id = :Id AND n.DateCreated LIKE :DateCreated
                  ';

        $stmt = $this->connection->prepare($query);
        $this->dateCreated = htmlspecialchars(strip_tags($this->dateCreated));
        $this->userid = htmlspecialchars(strip_tags($this->userid));

        $stmt->bindParam(':Id', $this->userid);
        $stmt->bindParam(':DateCreated', $this->dateCreated);

        $stmt->execute();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          $this->userid = $row['UserId'];
          $this->caloriesTarget = $row['CaloriesTarget'];
          $this->carbsTarget = $row['CarbsTarget'];
          $this->fatTarget = $row['FatTarget'];
          $this->proteinTarget = $row['ProteinTarget'];
          $this->fiberTarget = $row['FiberTarget'];
          $this->dateCreated = $row['DateCreated'];
          $this->dateUpdated = $row['DateUpdated'];
          $this->calciumTarget = $row['CalciumTarget'];
          $this->SodiumTarget = $row['SodiumTarget'];
          $this->vitaminATarget = $row['VitaminATarget'];
          $this->vitaminDTarget = $row['VitaminDTarget'];
          $this->vitaminCTarget = $row['VitaminCTarget'];


          $nutr_item = array(
            'message' => 'Today',
            'UserId' => $this->userid,
            'CaloriesTarget' => $this->caloriesTarget,
            'CarbsTarget' => $this->carbsTarget,
            'FatTarget' => $this->fatTarget,
            'ProteinTarget' => $this->proteinTarget,
            'SodiumTarget' => $this->sodiumTarget,
            'FiberTarget' => $this->fiberTarget,
            'CalciumTarget' => $this->calciumTarget,
            'VitaminATarget' => $this->vitaminATarget,
            'VitaminCTarget' => $this->vitaminCTarget,
            'VitaminDTarget' => $this->vitaminDTarget,
            'DateCreated' => $this->dateCreated,
            'DateUpdated' => $this->dateUpdated
          );

          echo json_encode( $nutr_item);
        }
        else{
          echo json_encode(
            array('message' => 'No Nutrition')
          );
        }
    }

      public function createNutrition(){

        $query = 'INSERT INTO ' . $this->table . ' (UserId, CaloriesTarget, CarbsTarget, ProteinTarget, FatTarget, FiberTarget,
                  SodiumTarget, CalciumTarget, VitaminATarget, VitaminDTarget, VitaminCTarget)
                  VALUES(:UserId, :CaloriesTarget, :CarbsTarget, :ProteinTarget, :FatTarget, :FiberTarget,
                  :SodiumTarget, :CalciumTarget, :VitaminATarget, :VitaminDTarget, :VitaminCTarget)
                  ';

        //prepare the statement on the db connection
        $stmt = $this->connection->prepare($query);

        //Make sure the data is clean
        $this->userid = htmlspecialchars(strip_tags($this->userid));
        $this->caloriesTarget = htmlspecialchars(strip_tags($this->caloriesTarget));
        $this->proteinTarget = htmlspecialchars(strip_tags($this->proteinTarget));
        $this->carbsTarget = htmlspecialchars(strip_tags($this->carbsTarget));
        $this->fatTarget = htmlspecialchars(strip_tags($this->fatTarget));
        $this->fiberTarget = htmlspecialchars(strip_tags($this->fiberTarget));
        $this->sodiumTarget = htmlspecialchars(strip_tags($this->sodiumTarget));
        $this->calciumTarget = htmlspecialchars(strip_tags($this->calciumTarget));
        $this->vitaminATarget = htmlspecialchars(strip_tags($this->vitaminATarget));
        $this->vitaminCTarget = htmlspecialchars(strip_tags($this->vitaminCTarget));
        $this->vitaminDTarget = htmlspecialchars(strip_tags($this->vitaminDTarget));

        //bind paremeters sent from post request
        $stmt->bindParam(':UserId', $this->userid);
        $stmt->bindParam(':CaloriesTarget', $this->caloriesTarget);
        $stmt->bindParam(':CarbsTarget', $this->carbsTarget);
        $stmt->bindParam(':FatTarget', $this->fatTarget);
        $stmt->bindParam(':FiberTarget', $this->fiberTarget);
        $stmt->bindParam(':ProteinTarget', $this->proteinTarget);
        $stmt->bindParam(':SodiumTarget', $this->sodiumTarget);
        $stmt->bindParam(':CalciumTarget', $this->calciumTarget);
        $stmt->bindParam(':VitaminATarget', $this->vitaminATarget);
        $stmt->bindParam(':VitaminCTarget', $this->vitaminCTarget);
        $stmt->bindParam(':VitaminDTarget', $this->vitaminDTarget);

        //check that the statement executes correctly
        if($stmt->execute()){
          return true;
        }

        //Print error if something goes wrong
      echo json_encode(
          array("error" => $stmt->error)
        );

        return false;
      }


    }
 ?>
