<?php
  class User{
    //connect to the Database
    private $connection;
    private $table = 'users';

    //table fields
    public $id;
    public $password;
    public $email;
    public $firstname;
    public $surname;
    public $gender;
    public $weight;
    public $height;
    public $birth_Date;
    public $age;
    public $active;
    //constructor for the datab. constructor is created with "__"
    public function __construct($db){
      $this->connection = $db;
    }

    public function register(){
      $query = 'INSERT INTO ' . $this->table . '
                (Email, Password, FirstName, Surname, BirthDate, Gender, WeightKg, HeightCm, Age, ActiveLevel)
                VALUES(:Email, :Password, :FirstName, :Surname, :BirthDate, :Gender,  :WeightKg, :HeightCm, :Age, :ActiveLevel)
                ';

      //prepare the query
      $stmt = $this->connection->prepare($query);

      //clean the data
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->password = htmlspecialchars(strip_tags($this->password));
      $this->firstname = htmlspecialchars(strip_tags($this->firstname));
      $this->surname = htmlspecialchars(strip_tags($this->surname));
      $this->birth_Date = htmlspecialchars(strip_tags($this->birth_Date));
      $this->gender = htmlspecialchars(strip_tags($this->gender));
      $this->weight = htmlspecialchars(strip_tags($this->weight));
      $this->height = htmlspecialchars(strip_tags($this->height));
      $this->active = htmlspecialchars(strip_tags($this->active));

      //calculate the age from the date of birth
      $this->age = DateTime::createFromFormat('Y-m-d', $this->birth_Date)
           ->diff(new DateTime(date('Y-m-d')))
           ->y;

      //bind the parameters to be posted
      $stmt->bindParam(':Email', $this->email);
      $stmt->bindParam(':Password', $this->password);
      $stmt->bindParam(':FirstName', $this->firstname);
      $stmt->bindParam(':Surname', $this->surname);
      $stmt->bindParam(':BirthDate', $this->birth_Date);
      $stmt->bindParam(':Gender', $this->gender);
      $stmt->bindParam(':WeightKg', $this->weight);
      $stmt->bindParam(':HeightCm', $this->height);
      $stmt->bindParam(':Age', $this->age);
      $stmt->bindParam(':ActiveLevel', $this->active);


      // run the query and check that it worked
      if($stmt->execute()){
        return true;
      }

      return false;
    }

    public function checkEmail(){
      $query = 'SELECT * FROM ' . $this->table . ' u
                WHERE u.Email = :Email';

      $stmt = $this->connection->prepare($query);

      $stmt->bindParam(':Email', $this->email);

      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      //if returned true the email exists in the database.
      if($row === false){
        return false;
      }
      else{
        return true;
      }
    }


    public function login(){
      $query = 'SELECT * FROM ' . $this->table . ' u
                WHERE u.Email = :Email';
      //pepare Statemment
      $stmt = $this->connection->prepare($query);
      //bind the password and id
      $stmt->bindParam(':Email', $this->email);
      //execute the $query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if($row === false){
        echo json_encode(
          array( 'message' => 'Unregistered Email' )
        );
      }
      else if($row['Password'] === $this->password){
        $this->id = $row['Id'];
        $this->firstname = $row['FirstName'];
        $this->surname = $row['Surname'];
        $this->email = $row['Email'];
        $this->gender = $row['Gender'];
        $this->weight = $row['WeightKg'];
        $this->age = $row['Age'];
        $this->height = $row['HeightCm'];
        $this->active = $row['ActiveLevel'];

      }
      else{
        echo json_encode(
          array( 'message' => 'Incorrect Password' )
        );
      }
    }

  }
?>
