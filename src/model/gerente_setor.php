<?php

require_once "tecnico.php";
require_once "gerente_setor_dao.php";

class GerenteSetor extends Tecnico
{
    public function cadastraTipoProblema($problema)
    { }

    public function cadastraProblema($problema)
    { }

    public function editaProblema($problema)
    { }

    public function removeProblema($problema)
    { }

    public function createTecnico($tecnico)
    {
        return $tecnico->create();
    }

    public function deleteTecnico($tecnico)
    {
        return $tecnico->delete();
    }

    public function create()
    {
        $dao = new GerenteSetorDAO();
        return $dao->create($this, $this->senha);
    }

    public function readBySetor()
    {
        $dao = new GerenteSetorDAO();
        return $dao->readBySetor($this);
    }

    public static function readJWTAndSet($decodedJWT, $gerente)
    {
        if (Tecnico::readJWTAndSet($decodedJWT, $gerente) && $gerente->getCargo() === 'G') {
            return $gerente;
        }

        return false;
    }
}
