<?php
require_once("dao.php");

class SetorDAO extends DAO {
   const TABLE = "tsetor";
   protected function read($query) {
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->execute();
      if($resultadoDB->rowCount == 1) {
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         extract($row);
         $setor->setNome($nome);
         $setor->setTelefone($telefone);
         $setor->setEmail($email);
      }
   }

   public function readByID($setor) {
      $query = "SELECT nome, telefone, email FROM " . self::TABLE .
               " WHERE id = " . $setor->getID();
      $this->read($query);
      return $setor;
   }

   public function readByTecnico($tecnico) {
      $query = "SELECT nome, telefone, email FROM " . self::TABLE .
               " WHERE id_tecnico = " . $tecnico->getID();
      $this->read($query);
      return $tecnico;
}

?>
