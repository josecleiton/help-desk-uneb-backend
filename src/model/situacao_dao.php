<?php

require_once("dao.php");

class SituacaoDAO extends DAO
{
  private $table = "tsituacao";
  public function read($situacao)
  {
    $resultadoDB = null;
    if ($situacao->getNome()) {
      $resultadoDB = $this->conn->prepare("SELECT * FROM $this->table WHERE nome = :nome");
      $resultadoDB->bindValue(":nome", $situacao->getNome(), PDO::PARAM_STR);
    } else {
      $resultadoDB = $this->conn->prepare("SELECT * FROM $this->table WHERE id = :id");
      $resultadoDB->bindValue(":id", $situacao->getID(), PDO::PARAM_INT);
    }
    $resultadoDB->execute();
    if ($resultadoDB->rowCount() == 1) {
      $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
      $situacao->setID($row["id"]);
      $situacao->setNome($row["nome"]);
      $situacao->setCor("#" . $row["cor"]);
      return $situacao;
    }
    return false;
  }
  public function readAll()
  {
    $resultadoDB = $this->conn->prepare("SELECT * FROM $this->table");
    $resultadoDB->execute();
    $situacoes = array();
    if ($resultadoDB->rowCount()) {
      while (($row = $resultadoDB->fetch(PDO::FETCH_ASSOC))) {
        $novaSituacao = new Situacao($row["id"]);
        $novaSituacao->setNome($row["nome"]);
        $novaSituacao->setCor("#" . $row["cor"]);
        array_push($situacoes, $novaSituacao);
      }
    }
    return $situacoes;
  }
}
