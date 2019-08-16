<?php
require_once("dao.php");
class PrioridadeDAO extends DAO {
   function read($prioridade) {
      $query = "SELECT descricao FROM " . self::TABLE .
               " WHERE id = " . $prioridade->getID();

      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->execute();
      if($resultadoDB->rowCount() == 1) {
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         $prioridade->setDescricao($row["descricao"]);
      }
      return $prioridade;
   }
}
?>
