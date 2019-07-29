<?php

require_once('chamado.php');

class ChamadoTI extends Chamado {
    private $caminhoDoArquivo;
    private $descricaoDoArquivo;
    private $tamanhoDoArquivo;

    function __constructor($id, $path, $desc, $tam) {

        parent::__constructor($id);
        $caminhoDoArquivo = $path;
        $descricaoDoArquivo = $desc;
        $tamanhoDoArquivo = $tam;
    }

    public function download() {

    }

    public function info() {
        
    }
    
}

?>