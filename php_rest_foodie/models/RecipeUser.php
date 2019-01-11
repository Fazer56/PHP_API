<?php
  class RecipeUser{
    private $connection;
    private $table = 'recipeuser';

    public $userId;
    public $recipeId;

    //constructor
    public function __construct($dbConn){
      $this->connection = $dbConn;
    }

    public function create(){

        $query = 'INSERT INTO ' . $this->table . ' VALUES(:RecipeId, :UserId)';
        $stmt = $this->connection->prepare($query);

        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->recipeId = htmlspecialchars(strip_tags($this->recipeId));

        $stmt->bindParam(':RecipeId', $this->recipeId);
        $stmt->bindParam(':UserId', $this->userId);

        if($stmt->execute()){
          return true;
        }

        //printf("Error: %s. \n", $stmt->error);

        return false;

      }
    }


?>
