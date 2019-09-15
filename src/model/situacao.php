<?php

require_once("situacao_dao.php");

class Situacao
{
  private $id;
  private $nome;
  private $cor;

  function __construct($id = 0)
  {
    $this->id = $id;
  }

  public function getID()
  {
    return $this->id;
  }

  public function getNome()
  {
    return $this->nome;
  }

  public function getCor()
  {
    return $this->cor;
  }

  public function getJSON()
  {
    return array(
      "nome" => $this->getNome(),
      "cor" => $this->getCor(),
    );
  }

  public function setNome($nome)
  {
    $this->nome = $nome;
  }

  public function setCor($cor)
  {
    $this->cor = $cor;
  }

  public function setID($id)
  {
    $this->id = $id;
  }

  public static function validaMudancaDeSituacao($sitAntes, $sitDepois)
  {
    $nomeAntes = $sitAntes->getNome();
    $nomeDepois = $sitDepois->getNome();
    if ($nomeAntes === 'Em Aberto') {
      return $nomeDepois === 'Em Atendimento' || $nomeDepois === 'Transferido';
    } else if ($nomeAntes === 'Em Atendimento') {
      return $nomeDepois === 'Transferido' || $nomeDepois === 'Pendente' || $nomeDepois === 'Concluido';
    } else if ($nomeAntes === 'Pendente') {
      return $nomeDepois === 'Em Atendimento';
    } else if ($nomeAntes === 'Pendente') {
      return $nomeDepois === 'Em Atendimento';
    } else if ($nomeAntes === 'Transferido') {
      return $nomeDepois === 'Em Atendimento';
    }
  }

  public function read()
  {
    $dao = new SituacaoDAO();
    return $dao->read($this);
  }
  public function readAll()
  {
    $dao = new SituacaoDAO();
    return $dao->readAll();
  }
}
