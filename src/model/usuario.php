<?php
require_once("usuario_dao.php");

class Usuario {
    protected $nome;
    protected $cpf;
    protected $email;
    protected $telefone;
    protected $chamados;

    function __construct($cpf) {
       $this->cpf = $cpf;
    }

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

    public function read() {
       $dao = new UsuarioDAO();
       return $dao->read($this);
    }

    public function getJSON() {
      $usuario_item = array(
         "cpf" => $this->getCPF(),
         "email" => $this->getEmail(),
         "telefone" => $this->getTelefone(),
         "auth_key" => $this->getAuthKey()
      );
      return json_encode($usuario_item);
    }



}

?>
