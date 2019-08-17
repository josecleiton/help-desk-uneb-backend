<?php
require_once("prioridade_dao.php");
class Prioridade {
   private $id;
   private $descricao;

   function __construct($id) {
      $this->id = $id;
   }

   public function getID() {
      return $this->id;
   }

   public function getDescricao() {
      return $this->descricao;
   }

   public function getJSON() {
      return array(
         "descricao" => $this->getDescricao()
      );
   }

   public function setDescricao($descricao) {
      $this->descricao = $descricao;
   }

   public function read() {
      $dao = new PrioridadeDAO();
      return $dao->read($this);
   }

}
?>
