<?php
class Database {

/*External
    private $host = "mysql4112int.cp.blacknight.com";
    private $username = "u1495828_food";
    private $password = "Katelinnane_56";
    private $database = "db1495828_food";
    private $connection;*/

    private $host = "127.0.0.1";
    private $username = "root";
    private $password = "Faoilean56";
    private $database = "foodie_db";
    private $connection;

    // get the database connection
    public function connect(){
        $this->connection = null;
        try{
          //this is a PDO object for the DSN database type,
          //the name of the database and the rest of the information needed
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
            $this->connection->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Error: " . $exception->getMessage();
        }

        return $this->connection;

    }
}
?>
