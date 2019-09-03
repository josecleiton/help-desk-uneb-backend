<?php
require_once(dirname(__file__) . "/../config/database.php");

class DAO {
   protected $conn;
   function __construct() {
      $this->conn = Database::getConnection();
   }
}

?>
