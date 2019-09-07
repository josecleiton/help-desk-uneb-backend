<?php
require_once("dao.php");
class PrioridadeDAO extends DAO {
   private $table = "tprioridade";
   const TABLE = "tprioridade";
   function read($prioridade) {
      $query = "SELECT descricao FROM $this->table WHERE id = :id";

      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->bindValue(":id", $prioridade->getID(), PDO::PARAM_INT);
      $resultadoDB->execute();
      if($resultadoDB->rowCount() == 1) {
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         $prioridade->setDescricao($row["descricao"]);
         return $prioridade;
      }
      return false;
   }
}
?>
