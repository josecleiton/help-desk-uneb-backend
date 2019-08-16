<?php
require_once("usuario.php");
require_once("tecnico_dao.php");

class Tecnico extends Usuario {
    protected $login;
    protected $setor;
    protected $chamados;

    function __construct($login) {
       $this->login = $login;
    }

    public function getLogin() {
       return $this->login;
    }

    public function getSetor() {
       if($this->getSetor()) {
          return $this->getSetor();
       } else {
          $setorDAO = new SetorDAO();
          $this->setSetor($setorDAO->readByTecnico($this));
          return $this->setor;
       }
    }

    public function setSetor($setor) {
       $this->setor = $setor;
    }

    public function read() {
       $dao = new TecnicoDAO();
       return $dao->read($this);
    }

    public function getChamados() {
       if($this->chamados) {
          return $this->chamados;
       } else {
          $chamadoDAO = new ChamadoDAO();
          $this->setChamados($chamadoDAO->readByTecnico($this));
          return $this->chamados;
       }
    }


    public function atendeChamado($chamado) {

    }

    public function encaminhaChamado($chamado, $setor) {

    }

    public function concluiChamado($chamado) {

    }

    public function alteraSituacao($chamado, $situacao, $alteracao) {

    }
}
?>
