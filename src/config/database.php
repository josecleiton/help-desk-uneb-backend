<?php
class Database {
  // get the database connection
   public static function getConnection(){
      $host = "lp3_db";
      $db_name = "help-desk-uneb";
      $username = "root";
      $password = "senhaforte";
      $conn = null;
      try{
          $conn = new PDO("mysql:dbname=" . $db_name . ";host=" . $host, $username, $password);
          $conn->exec("set names utf8");
      } catch(PDOException $e){
          echo "Connection error: " . $e->getMessage();
          throw PDOException;
      }

      return $conn;
   }
}

?>
