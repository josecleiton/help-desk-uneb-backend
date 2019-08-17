<?php
require_once("dao.php");
require_once("setor.php");

class SetorDAO extends DAO {
   const TABLE = "tsetor";
   protected function read($setor, $query) {
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->execute();
      if($resultadoDB->rowCount() == 1) {
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         extract($row);
         $setor->setNome($nome);
         $setor->setTelefone($telefone);
         $setor->setEmail($email);
      }
      return $setor;
   }

   public function readByID($setor) {
      $query = "SELECT nome, telefone, email FROM " . self::TABLE .
               " WHERE id = " . $setor->getID();
      return $this->read($setor, $query);
   }

   public function readByTecnico($tecnico) {
      $query = "SELECT nome, telefone, email FROM " . self::TABLE .
               " WHERE id_tecnico = " . $tecnico->getID();
      return $this->read(new Setor(), $query);
   }
}

?>
