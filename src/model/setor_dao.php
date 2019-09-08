<?php
require_once("dao.php");
require_once("setor.php");

class SetorDAO extends DAO {
   private $table = "tsetor";

   protected function readOne($setor, $resultadoDB) {
      $resultadoDB->execute();
      if($resultadoDB->rowCount() == 1) {
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         if(array_key_exists("nome", $row)) {
            $setor->setNome($row["nome"]);
         }
         if(array_key_exists("id", $row)) {
            $setor->setID($row["id"]);
         }
         $setor->setTelefone($row["telefone"]);
         $setor->setEmail($row["email"]);
      }
      return $setor;
   }

   public function create($setor) {

      $query = "INSERT INTO $this->table (nome, telefone, email) values (:nome, :telefone, :email)";
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->bindValue("nome", $setor->getNome(), PDO::PARAM_STR);
      $resultadoDB->bindValue("email", $setor->getEmail(), PDO::PARAM_STR);
      $resultadoDB->bindValue("telefone", $setor->getTelefone(), PDO::PARAM_STR);
      if($resultadoDB->execute()) {
         $setor->setID($this->conn->lastInsertId());
         return $resultadoDB->rowCount();
      }
      return 0;
   }

   public function readByID($setor) {
      // $query = "SELECT nome, telefone, email FROM " . self::TABLE .
      //          " WHERE id = " . $setor->getID();
      $resultadoDB = $this->conn->prepare("SELECT nome, telefone, email FROM $this->table WHERE id = :id");
      $resultadoDB->bindValue(":id", $setor->getID(), PDO::PARAM_INT);
      return $this->readOne($setor, $resultadoDB);
   }

   public function readByNome($setor) {
      $resultadoDB = $this->conn->prepare("SELECT id,telefone, email FROM $this->table WHERE nome = :nome");
      $resultadoDB->bindValue(":nome", $setor->getNome(), PDO::PARAM_STR);
      return $this->readOne($setor, $resultadoDB);
   }

   public function readByTecnico($tecnico) {
      // $query = "SELECT nome, telefone, email FROM " . self::TABLE .
      //          " WHERE id_tecnico = " . $tecnico->getID();
      $query = "SELECT nome, telefone, email FROM $this->table WHERE id_tecnico = :idtecnico";
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->bindValue(":idtecnico", $tecnico->getID());
      return $this->readOne(new Setor(), $query);
   }

   public function readAll() {
      $query = "SELECT * FROM $this->table";
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->execute();
      $setores = array();
      while($row = $resultadoDB->fetch(PDO::FETCH_ASSOC)) {
         $setor = new Setor();
         $setor->setID($row["id"]);
         $setor->setNome($row["nome"]);
         $setor->setTelefone($row["telefone"]);
         $setor->setEmail($row["email"]);
         array_push($setores, $setor);
      }
      return $setores;
   }
   public function readProblemas($setor) {

   }
   public function delete($setor) {
      // $query = "DELETE FROM " . self::TABLE . " WHERE nome = " . $setor->getNome();
      $resultadoDB = $this->conn->prepare("DELETE FROM $this->table WHERE nome = :nome");
      $resultadoDB->bindValue(":nome", $setor->getNome());
      $resultadoDB->execute();
      return $resultadoDB->rowCount();
   }
}

?>
