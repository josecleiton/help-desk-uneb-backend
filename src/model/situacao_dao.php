<?php

require_once("dao.php");

class SituacaoDAO extends DAO {
   const TABLE = "tsituacao";
   public function read($situacao) {
      $query = "SELECT s.nome, c.hex " .
               "FROM " . self::TABLE . " s, tcor c " .
               "WHERE s.id = " . $situacao->getID() . " AND s.id_cor = c.id";

      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->execute();
      // echo "TEEEEEEST";
      if($resultadoDB->rowCount() == 1) {
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         extract($row);
         $situacao->setNome($nome);
         $situacao->setCor("#" . $hex);
      }
      return $situacao;
   }
}

?>
