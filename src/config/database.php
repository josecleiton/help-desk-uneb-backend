<?php
class Database {
   private $host = "lp3_db";
   private $db_name = "help-desk-uneb";
   private $username = "root";
   private $password = "senhaforte";
   private $options = array(
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
   );
   private $conn;

  // get the database connection
   public function getConnection(){
     $this->conn = null;
     try{
         $this->conn = new PDO("mysql:dbname=" . $this->db_name . ";host=" . $this->host, $this->username, $this->password, $this->options);
     } catch(PDOException $exception){
         echo "Connection error: " . $exception->getMessage();
     }

     return $this->conn;
   }
}

?>
