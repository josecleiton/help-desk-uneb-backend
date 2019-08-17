<?php
require_once("usuario.php");
require_once("tecnico_dao.php");

class Tecnico extends Usuario {
    protected $login;
    protected $setor;
    protected $chamados;
    protected $authKey;

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

    public function getChamados() {
       if($this->chamados) {
          return $this->chamados;
       } else {
          $chamadoDAO = new ChamadoDAO();
          $this->setChamados($chamadoDAO->readByTecnico($this));
          return $this->chamados;
       }
    }

    public function getAuthKey() {
       return $this->authKey;
    }

    public function getJSON() {
       $json = parent::getJSON();
       $json["login"] = $this->getLogin();
       return $json;
    }

    public function setSetor($setor) {
       $this->setor = $setor;
    }

    public function setAuthKey($authKey) {
       $this->authKey = $authKey;
    }

    public function setChamados($chamados) {
       $this->chamados = $chamados;
    }

    public function read() {
       $dao = new TecnicoDAO();
       return $dao->read($this);
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
