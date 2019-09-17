<?php

require_once('chamado.php');
require_once('chamado_ti_dao.php');

class ChamadoTI extends Chamado
{
  private $software;
  private $dataUtilizacao;
  private $sala;
  private $link;
  private $plugins;

  public function getSoftware()
  {
    return $this->software;
  }

  public function getDataUtilizacao()
  {
    return $this->dataUtilizacao;
  }

  public function getSala()
  {
    return $this->sala;
  }

  public function getLink()
  {
    return $this->link;
  }

  public function getPlugins()
  {
    return $this->plugins;
  }

  public function getJSON($nullVal = array())
  {
    $chamadoJSON = parent::getJSON($nullVal);
    if ($this->software) {
      $chamadoJSON["software"] = $this->software;
      $chamadoJSON["data_utilizacao"] = $this->software;
      $chamadoJSON["sala"] = $this->sala;
      $chamadoJSON["link"] = $this->link;
      $chamadoJSON["plugins"] = $this->plugins;
    }
    return $chamadoJSON;

    // array_push($chamadoJSON,
    //   "software" => $this->software,
    //   "data_utilizacao" => $dataUtilizacao,
    //   "sala" => $this->sala,
    //   "link" => $this->link,
    //   "plugins" => $this->plugins,

    // );
  }

  public function read($populate)
  {
    if (parent::read($populate)) {
      $dao = new ChamadoTIDAO();
      return $dao->read($this);
    }
    return false;
  }

  public function readBySetor()
  {
    $result = parent::readBySetor();
    $dao = new ChamadoTIDAO();
    foreach ($result as $chamado) {
      $dao->read($chamado);
    }
    return $result;
  }

  public function setSoftware($software)
  {
    $this->software = $software;
  }

  public function setDataUtilizacao($dataUtilizacao)
  {
    $this->dataUtilizacao = $dataUtilizacao;
  }

  public function setLink($link)
  {
    $this->link = $link;
  }

  public function setSala($sala)
  {
    $this->sala = $sala;
  }

  public function setPlugins($plugins)
  {
    $this->plugins = $plugins;
  }

  public function download()
  { }

  public function info()
  { }

  public function create()
  {
    if (parent::create()) {
      $dao = new ChamadoTIDAO();
      return $dao->create($this);
    }
    return false;
  }
}
