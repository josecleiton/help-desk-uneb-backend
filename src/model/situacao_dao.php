<?php

require_once("dao.php");

class SituacaoDAO extends DAO {
   private $table = "tsituacao";
   public function read($situacao) {
      $resultadoDB = $this->conn->prepare("SELECT * FROM $this->table WHERE id = :id");
      $resultadoDB->bindValue(":id", $situacao->getID(), PDO::PARAM_INT);
      $resultadoDB->execute();
      // echo "TEEEEEEST";
      if($resultadoDB->rowCount() == 1) {
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         $situacao->setNome($row["nome"]);
         $situacao->setCor("#" . $row["cor"]);
         return $situacao;
      }
      return false;
   }
}

?>
