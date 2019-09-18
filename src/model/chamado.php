<?php
require_once("chamado_dao.php");
require_once("upload.php");

class Chamado
{
  protected $id;
  protected $descricao;
  protected $data;
  protected $alteracoes;
  protected $tombo;
  protected $usuario;
  protected $setor;
  protected $tecnico;
  protected $problema;
  protected $arquivo;

  function __construct($id = 0)
  {
    $this->id = $id;
  }

  public function getID()
  {
    return $this->id;
  }

  public function getAlteracao($alteracaoIdx = -1)
  {
    if ($alteracaoIdx === -1)
      $alteracaoIdx = count($this->alteracoes) - 1;
    return $this->alteracoes[$alteracaoIdx];
  }

  public function getSituacao()
  {
    return $this->getAlteracao()->getSituacao();
  }

  public function getDescricao()
  {
    return $this->descricao;
  }

  public function getData()
  {
    return $this->data;
  }

  public function getTombo()
  {
    return $this->tombo;
  }

  public function getUsuario()
  {
    return $this->usuario;
  }

  public function getSetor()
  {
    return $this->setor;
  }

  public function getTecnico()
  {
    return $this->tecnico;
  }

  public function getAlteracoes()
  {
    return $this->alteracoes;
  }

  public function getProblema()
  {
    return $this->problema;
  }

  public function getArquivo()
  {
    return Upload::getCaminhoExterno($this->arquivo);
  }

  protected function getAlteracoesJSON()
  {
    if (!$this->alteracoes) return;
    return array_map(function ($alteracao) {
      return $alteracao->getJSON();
    }, $this->alteracoes);
  }

  public function getJSON($nullVal = array())
  {
    $usuario = $this->getUsuario();
    $tecnico = $this->getTecnico();
    // var_dump($tecnico);
    return array(
      "id" => $this->getID(),
      "descricao" => $this->getDescricao(),
      // "data" => $this->getData(),
      "alteracoes" => $this->getAlteracoesJSON(),
      "usuario" => array_key_exists("usuario", $nullVal) ? null : $usuario->getJSON(array(
        "chamados" => true
      )),
      "tecnico" => array_key_exists("tecnico", $nullVal) ? null : $tecnico ?  $tecnico->getJSON(array(
        "chamados" => true,
        "setor" => true,
      )) : null,
      "tombo" => $this->getTombo(),
      "setor" => array_key_exists("setor", $nullVal) ? null : $this->getSetor()->getJSON(),
      "problema" => ($problema = $this->getProblema()) ? $problema->getJSON() : null,
      "arquivo" => $this->getArquivo(),
    );
  }

  public function setID($id)
  {
    $this->id = $id;
  }

  public function setDescricao($descricao)
  {
    $this->descricao = $descricao;
  }

  public function setData($data)
  {
    $this->data = $data;
  }

  public function setTombo($tombo)
  {
    $this->tombo = $tombo;
  }

  public function setUsuario($usuario)
  {
    $this->usuario = $usuario;
  }

  public function setSetor($setor)
  {
    $this->setor = $setor;
  }

  public function setTecnico($tecnico)
  {
    $this->tecnico = $tecnico;
  }

  public function setAlteracoes($alteracoes)
  {
    $this->alteracoes = $alteracoes;
  }

  public function setProblema($problema)
  {
    $this->problema = $problema;
  }

  public function setArquivo($arquivo)
  {
    $this->arquivo = $arquivo;
  }

  public function delete()
  {
    $dao = new ChamadoDAO();
    return $dao->delete($this);
  }
  public function create()
  {
    $dao = new ChamadoDAO();
    return $dao->create($this);
  }
  public function readBySetor()
  {
    $dao = new ChamadoDAO();
    return $dao->readBySetor($this);
  }
  public function readEmAberto($setor)
  {
    $dao = new ChamadoDAO();
    return $dao->readEmAberto($setor);
  }

  public function read($populate)
  {
    $dao = new ChamadoDAO();
    return $dao->readByID($this, $populate);
  }

  public function update()
  {
    $dao = new ChamadoDAO();
    return $dao->update($this);
  }
}
