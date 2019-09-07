<?php
require_once("usuario_dao.php");

class Usuario {
    protected $nome;
    protected $cpf;
    protected $email;
    protected $telefone;
    protected $chamados;

    private function cancelaChamado($chamado) {

    }

    private function cadastraChamado($chamado) {

    }

    public function getCPF() {
       return $this->cpf;
    }

    public function getNome() {
       return $this->nome;
    }

    public function getEmail() {
       return $this->email;
    }

    public function getTelefone() {
       return $this->telefone;
    }

    public function getChamados() {
       return $this->chamados;
    }

    public function getChamadosJSON() {
       if(!$this->chamados) return null;
       return array_map(function ($chamado) {
          return $chamado->getJSON(array(
             "usuario" => true
          ));
       }, $this->getChamados());
    }

    public function setCPF($cpf) {
       $this->cpf = $cpf;
    }

    public function setNome($nome) {
       $this->nome = $nome;
    }

    public function setEmail($email) {
       $this->email = $email;
    }

    public function setTelefone($telefone) {
       $this->telefone = $telefone;
    }

    public function setChamados($chamados) {
       $this->chamados = $chamados;
    }

    public function read($spread = array()) {
       $dao = new UsuarioDAO();
       return $dao->read($this, $spread);
    }

    public function getJSON($nullVal = array()) {
      return array(
         "nome" => $this->getNome(),
         "cpf" => $this->getCPF(),
         "email" => $this->getEmail(),
         "telefone" => $this->getTelefone(),
         "chamados" => array_key_exists("chamados", $nullVal) ? null : $this->getChamadosJSON(),
      );
    }

    public function existe() {
       $dao = new UsuarioDAO();
       return $dao->existe($this);
    }

    public function create() {
       $dao = new UsuarioDAO();
       return $dao->create($this);
    }


}

?>
