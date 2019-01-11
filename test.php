<?php

  class Food{
    private $connection;
    private $table = 'foodeaten';

    public $foodname;
    public $calories;
    public $carbs;
    public $fat;
    public $fiber;
    private $date ;
    public $datetoday;
    public $userid;

    //constructor
    public function __constructor($dbConn){
      $this->connection = $dbConn;
      //$this->userid = $uid;
    }

    // GET Foods
    public function read($date1){
      $this->date = $date1;
    	return $this->date;
    }

}
  
  $date1 = date("Y-m-d");
  //echo $date1;

  //create a Food object
  $food = new Food('dude');


  //food eaten query
  $result = $food->read($date1);
  echo 'This  ' . $date1 . '  ';


  /*$date = date("Y-m-d");
  echo $date;*/
?>


