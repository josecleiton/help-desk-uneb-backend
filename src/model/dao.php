<?php
require_once(dirname(__FILE__) . "/../config/database.php");

class DAO {
   protected $conn;
   function __construct() {
      $this->conn = Database::getConnection();
   }
   function __destruct() {
      $this->conn = null;
   }
}

?>
