<?php
require_once(dirname(__file__) . "/../config/database.php");

class DAO {
   protected $conn;
   function __construct() {
      $database = new Database();
      $this->conn = $database->getConnection();
   }
}

?>
