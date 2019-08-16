<?php

require_once("situacao_dao.php");

class Situacao {
   private $id;
   private $nome;
   private $cor;

   function __construct($id) {
      $this->id = $id;
   }

   public function getID() {
      return $this->id;
   }

   public function getNome() {
      return $this->nome;
   }

   public function getCor() {
      return $this->cor;
   }

   public function setNome($nome) {
      $this->nome = $nome;
   }

   public function setCor($cor) {
      $this->cor = $cor;
   }

   public function read() {
      $dao = new SituacaoDAO();
      return $dao->read($this);
   }
}

?>
