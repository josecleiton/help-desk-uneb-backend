<?php
require_once("database.php");

class DAO
{
  protected $conn;
  function __construct()
  {
    $this->conn = Database::getConnection();
  }
  function __destruct()
  {
    $this->conn = null;
  }
}
