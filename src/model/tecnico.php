<?php
require_once("usuario.php");
require_once("tecnico_dao.php");
require_once(dirname(__FILE__)."/../config/env.php");
require_once(dirname(__file__)."/../vendor/autoload.php");
use \Firebase\JWT\JWT;
class Tecnico extends Usuario {
    protected $login;
    protected $setor;
    protected $chamados;
    protected $cargo;
    protected $senha;

    public function getLogin() {
       return $this->login;
    }

    public function getSetor() {
       if($this->setor) {
          return $this->setor;
       } else {
          $setorDAO = new SetorDAO();
          $this->setSetor($setorDAO->readByTecnico($this));
          return $this->getSetor();
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

    public function getChamadosJSON() {
       return array_map(function($chamado){
          return $chamado->getJSON();
       }, $this->getChamados());
    }

    public function getCargo() {
       return $this->cargo;
    }

    public function getJSON($nullVal = array()) {
   //  protected $login;
   //  protected $setor;
   //  protected $chamados;
   //  protected $authKey;
      return array(
         "nome" => $this->getNome(),
         "login" => $this->getLogin(),
         "email" => $this->getEmail(),
         "telefone" => $this->getTelefone(),
         "setor" => array_key_exists("setor", $nullVal) ? null : $this->getSetor()->getJSON(),
         "chamados" => array_key_exists("chamados", $nullVal) ? null : $this->getChamados(),
      );
    }

    public function setLogin($login) {
       $this->login = $login;
    }
    public function setSenha($senha) {
       $this->senha = $senha;
    }
    public function setSetor($setor) {
       $this->setor = $setor;
    }
    public function setCargo($cargo) {
       $this->cargo = $cargo;
    }

    public function setChamados($chamados) {
       $this->chamados = $chamados;
    }

    public function read($spread = array()) {
       $dao = new TecnicoDAO();
       return $dao->read($this, $spread);
    }

    public function login($senha) {
       $dao = new TecnicoDAO();
       return $dao->auth($this, $senha);
    }

    public function toJWT() {
       $token = array(
          "nome" => $this->getNome(),
          "login" => $this->getLogin(),
          "senha" => $this->senha,
          "email" => $this->getEmail(),
          "cargo" => $this->getCargo(),
          "telefone" => $this->getTelefone()
       );
       return JWT::encode($token, ENV::getAppKey());
    }

    public function create() {
       $dao = new TecnicoDAO();
       return $dao->create($this, $this->senha);
    }

    public function auth() {
       $dao = new TecnicoDAO();
       return $dao->auth($this, $this->senha);
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
