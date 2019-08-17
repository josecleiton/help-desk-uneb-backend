<?php
require_once("chamado_dao.php");

class Chamado {
    protected $id;
    protected $descricao;
    protected $data;
    protected $alteracoes;
    protected $tombo;
    protected $usuario;
    protected $setor;
    protected $tecnico;

    function __construct($id) {
       $this->id = $id;
    }

    public function getID() {
       return $this->id;
    }

    public function getSituacao($alteracao = -1) {
       if($alteracao == -1)
          $alteracao = count($this->alteracoes);
       return $this->alteracoes[$alteracao];
    }

    public function getDescricao() {
       return $this->descricao;
    }

    public function getData() {
       return $this->data;
    }

    public function getTombo() {
       return $this->tombo;
    }

    public function getUsuario() {
       return $this->usuario;
    }

    public function getSetor() {
       return $this->setor;
    }

    public function getTecnico() {
       return $this->tecnico;
    }

    public function getAlteracoes() {
       return $this->alteracoes;
    }

    protected function getAlteracoesJSON() {
       return array_map(function ($alteracao){
          return $alteracao->getJSON();
       }, $this->getAlteracoes());
    }

    public function getJSON() {
      $usuario = $this->getUsuario();
      $tecnico = $this->getTecnico();
      return array(
         "id" => $this->getID(),
         "descricao" => $this->getDescricao(),
         "data" => $this->getData(),
         "alteracoes" => $this->getAlteracoesJSON(),
         "usuario" => ($usuario) ? $usuario->getJSON() : null,
         "tecnico" => ($tecnico) ? $tecnico->getJSON() : null,
         "tombo" => $this->getTombo(),
         "setor" => $this->getSetor()->getJSON(),
      );
    }

    public function setDescricao($descricao) {
       $this->descricao = $descricao;
    }

    public function setData($data) {
       $this->data = $data;
    }

    public function setTombo($tombo) {
       $this->tombo = $tombo;
    }

    public function setUsuario($usuario) {
       $this->usuario = $usuario;
    }

    public function setSetor($setor) {
       $this->setor = $setor;
    }

    public function setTecnico($tecnico) {
       $this->tecnico = $tecnico;
    }

    public function setAlteracoes($alteracoes) {
       $this->alteracoes = $alteracoes;
    }
}

?>
