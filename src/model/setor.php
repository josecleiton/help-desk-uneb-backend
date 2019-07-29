<?php 
class Setor {
    private nome;
    private tel;
    private email;
    private problemas;

    function __constructor($_nome, $_tel, $_email) {
        $this->nome = $_nome;
        $this->tel = $_tel;
        $this->email = $_email;
    } 
}
?>