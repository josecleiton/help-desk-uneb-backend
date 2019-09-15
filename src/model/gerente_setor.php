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
    $tecnico = new Tecnico();
    $tecnico->setSetor($this->setor);
    return $tecnico->readBySetor();
  }

  public static function readJWTAndSet($decodedJWT, $gerente)
  {
    if (Tecnico::readJWTAndSet($decodedJWT, $gerente) && (($cargo = $gerente->getCargo()) === 'A' || $cargo === 'G'))
      return $gerente;
    return false;
  }
}
