<?php

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\Exception;

class Database
{
  // get the database connection
  public static function getConnection()
  {
    try {
      $dotenv = Dotenv::create(dirname(__file__) . '/../');
      $dotenv->load();
      $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);
    } catch (\Exception $e) {
      echo $e->getMessage();
      throw new Exception("ENV");
    }
    $host = getenv("DB_HOST");
    $db_name = getenv("DB_NAME");
    $username = getenv("DB_USER");
    $password = getenv("DB_PASS");
    $conn = null;
    try {
      $conn = new PDO("mysql:dbname=" . $db_name . ";host=" . $host, $username, $password);
      $conn->exec("set names utf8");
    } catch (PDOException $e) {
      echo "Connection error: " . $e->getMessage();
      throw PDOException;
    }

    return $conn;
  }
}
