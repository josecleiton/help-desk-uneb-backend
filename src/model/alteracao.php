
<?php

require_once('alteracao_dao.php');
require_once('email.php');

class Alteracao
{
  private $id;
  private $descricao;
  private $data;
  private $situacao;
  private $prioridade;
  private $chamado;
  private $tecnico;

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

  public function getTecnico()
  {
    return $this->tecnico;
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

  public function setTecnico($tecnico)
  {
    $this->tecnico = $tecnico;
  }

  public function create()
  {
    $dao = new AlteracaoDAO();
    try {
      $dao->create($this);
      // $mailer = new Email($this);
      // $mailer->send();
      return true;
    } catch (\Exception $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function readAllByChamado()
  {
    $dao = new AlteracaoDAO();
    return $dao->readAllByChamado($this->chamado);
  }
}

?>
