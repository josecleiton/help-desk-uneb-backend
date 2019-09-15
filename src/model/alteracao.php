
<?php

require_once('alteracao_dao.php');

class Alteracao
{
  private $id;
  private $descricao;
  private $data;
  private $situacao;
  private $prioridade;
  private $chamado;
  // private $tecnico;

  function __construct($id = 0)
  {
    $this->id = $id;
  }

  public function getJSON()
  {
    return array(
      "descricao" => $this->getDescricao(),
      "data" => $this->getData(),
      "situacao" => $this->getSituacao()->getJSON(),
      "prioridade" => $this->getPrioridade()->getJSON(),
    );
  }

  public function getID()
  {
    return $this->id;
  }

  public function getDescricao()
  {
    return $this->descricao;
  }

  public function getData()
  {
    return $this->data;
  }

  public function getPrioridade()
  {
    return $this->prioridade;
  }

  public function getSituacao()
  {
    return $this->situacao;
  }

  public function getChamado()
  {
    return $this->chamado;
  }

  public function setID($id)
  {
    $this->id = $id;
  }

  public function setDescricao($descricao)
  {
    $this->descricao = $descricao;
  }

  public function setChamado($chamado)
  {
    $this->chamado = $chamado;
  }

  public function setData($data)
  {
    $this->data = $data;
  }

  public function setSituacao($situacao)
  {
    $this->situacao = $situacao;
  }

  public function setPrioridade($prioridade)
  {
    $this->prioridade = $prioridade;
  }

  public function create($tecnico = null)
  {
    $dao = new AlteracaoDAO();
    return $dao->create($this, $tecnico);
  }

  public function readAllByChamado()
  {
    $dao = new AlteracaoDAO();
    return $dao->readAllByChamado($this->chamado);
  }
}

?>
