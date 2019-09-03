<?php
require_once("dao.php");

class TecnicoDAO extends DAO {
   const TABLE = "ttecnico";
   public function read($tecnico) {
      $query = "SELECT * FROM " . self::TABLE .
               " WHERE login = '". $tecnico->getLogin() . "'";
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->execute();
      if($resultadoDB->rowCount() == 1) {
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         $tecnico->setNome($row["nome"]);
         $tecnico->setEmail($row["email"]);
         $tecnico->setTelefone($row["telefone"]);
      }
      return $tecnico;
   }
}
