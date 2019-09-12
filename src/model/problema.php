<?php
require_once 'problema_dao.php';
class Problema
{
  private $id;
  private $descricao;
  private $setor;

  public function getID()
  {
    return $this->id;
  }

  public function getDescricao()
  {
    return $this->descricao;
  }

  public function getSetor()
  {
    if ($this->setor) {
      return $this->setor;
    } else {
      $setor = new Setor();
      return $this->setor = $setor->readByProblema($this);
    }
  }

  public function getJSON($spread = array())
  {
    return array(
      "id" => $this->id,
      "descricao" => $this->descricao,
      "setor" => $spread["setor"] ? $this->getSetor()->getJSON() : null,
    );
  }

  public function setDescricao($descricao)
  {
    $this->descricao = $descricao;
  }

  public function setSetor($setor)
  {
    $this->setor = $setor;
  }

  public function setID($id)
  {
    $this->id = $id;
  }

  public function create()
  {
    $dao = new ProblemaDAO();
    return $dao->create($this);
  }
  public function readAllBySetor($nullVal = array())
  {
    $dao = new ProblemaDAO();
    return $dao->readAllBySetor($this, $nullVal);
  }
}
