<?php
require_once("problema_dao.php");
require_once("setor_dao.php");

class Setor {
   private $id;
   private $nome;
   private $tel;
   private $email;
   private $problemas;

   public function getID() {
      return $this->id;
   }

   public function getNome() {
      return $this->nome;
   }

   public function getTelefone() {
      return $this->tel;
   }

   public function getEmail() {
      return $this->email;
   }

   public function getProblemas() {
      if($this->problemas) {
         return $this->problemas;
      } else {
         $problemDAO = new ProblemaDAO();
         $this->setProblemas($problemDAO->read($this));
         return $this->problemas();
      }
   }

   public function getJSON() {
      return array(
         "cod" => $this->id,
         "nome" => $this->nome,
         "telefone" => $this->tel,
         "email" => $this->email,
         "problemas" => $this->problemas,
      );
   }

   public function setID($id) {
      $this->id = $id;
   }

   public function setNome($nome) {
      $this->nome = $nome;
   }

   public function setTelefone($telefone) {
      $this->tel = $telefone;
   }

   public function setEmail($email) {
      $this->email = $email;
   }

   public function setProblemas($problemas) {
      $this->problemas = $problemas;
   }

   public function create() {
      $dao = new SetorDAO();
      return $dao->create($this);
   }

   public function read() {
      $dao = new SetorDAO();
      return ($this->id) ? $dao->readByID($this) : $dao->readByNome($this);
   }

   public function readAll() {
      $dao = new SetorDAO();
      return $dao->readAll();
   }

   public function delete() {
      $dao = new SetorDAO();
      return $dao->delete($this);
   }

}
?>
