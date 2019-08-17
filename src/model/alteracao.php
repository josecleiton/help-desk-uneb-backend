
<?php

class Alteracao {
   private $id;
   private $descricao;
   private $data;
   private $situacao;
   private $prioridade;

   function __construct($id) {
      $this->id = $id;

   }

   public function getJSON() {
      return array(
         "descricao" => $this->getDescricao(),
         "data" => $this->getData(),
         "situacao" => $this->getSituacao()->getJSON(),
         "prioridade" => $this->getPrioridade()->getJSON(),
      );
      
   }

   public function getID() {
      return $this->id;
   }

   public function getDescricao() {
      return $this->descricao;
   }

   public function getData() {
      return $this->data;
   }

   public function getPrioridade() {
      return $this->prioridade;
   }

   public function getSituacao() {
      return $this->situacao;
   }

   public function setDescricao($descricao) {
      $this->descricao = $descricao;
   }

   public function setData($data) {
      $this->data = $data;
   }

   public function setSituacao($situacao) {
      $this->situacao = $situacao;
   }

   public function setPrioridade($prioridade) {
      $this->prioridade = $prioridade;
   }

}

?>
