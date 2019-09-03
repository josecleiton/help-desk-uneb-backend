<?php
require_once("dao.php");
require_once("setor.php");

class SetorDAO extends DAO {
   const TABLE = "tsetor";

   protected function readOne($setor, $resultadoDB) {
      $resultadoDB->execute();
      if($resultadoDB->rowCount() == 1) {
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         $setor->setNome($row["nome"]);
         $setor->setTelefone($row["telefone"]);
         $setor->setEmail($row["email"]);
      }
      return $setor;
   }

   public function create($setor) {

      $query = "INSERT INTO " . self::TABLE . " (nome, telefone, email) values (:nome, :telefone, :email)";
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->bindParam("nome", $nome);
      $resultadoDB->bindParam("email", $email);
      $resultadoDB->bindParam("telefone", $telefone);
      $nome = $setor->getNome();
      $email = $setor->getEmail();
      $telefone = $setor->getTelefone();
      if($resultadoDB->execute()) {
         $setor->setID($this->conn->lastInsertId());
         return $resultadoDB->rowCount();
      }
      return 0;
   }

   public function readByID($setor) {
      // $query = "SELECT nome, telefone, email FROM " . self::TABLE .
      //          " WHERE id = " . $setor->getID();
      $query = "SELECT nome, telefone, email FROM " . self::TABLE .
               " WHERE id = :idsetor";
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->bindValue(":idsetor", $setor->getID());
      return $this->readOne($setor, $resultadoDB);
   }

   public function readByTecnico($tecnico) {
      // $query = "SELECT nome, telefone, email FROM " . self::TABLE .
      //          " WHERE id_tecnico = " . $tecnico->getID();
      $query = "SELECT nome, telefone, email FROM " . self::TABLE .
               " WHERE id_tecnico = :idtecnico";
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->bindValue(":idtecnico", $tecnico->getID());
      return $this->readOne(new Setor(), $query);
   }

   public function readAll() {
      $query = "SELECT * FROM " . self::TABLE;
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
      $query = "DELETE FROM " . self::TABLE . " WHERE nome = :nome";
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->bindValue(":nome", $setor->getNome());
      $resultadoDB->execute();
      return $resultadoDB->rowCount();
   }
}

?>
