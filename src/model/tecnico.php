<?php
require_once('usuario.php');
class Tecnico extends Usuario {
    protected $login;
    protected $setor;

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