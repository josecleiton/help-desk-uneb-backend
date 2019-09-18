<?php

require_once("dao.php");

class SituacaoDAO extends DAO
{
  private $table = "tsituacao";
  public function read($situacao)
  {
    $stmt = null;
    if ($situacao->getNome()) {
      $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE nome = :nome");
      $stmt->bindValue(":nome", $situacao->getNome(), PDO::PARAM_STR);
    } else {
      $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = :id");
      $stmt->bindValue(":id", $situacao->getID(), PDO::PARAM_INT);
    }
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $situacao->setID($row["id"]);
      $situacao->setNome($row["nome"]);
      $situacao->setCor("#" . $row["cor"]);
      return $situacao;
    }
    return false;
  }
  public function readAll()
  {
    $stmt = $this->conn->prepare("SELECT * FROM $this->table");
    $stmt->execute();
    $situacoes = array();
    if ($stmt->rowCount()) {
      while (($row = $stmt->fetch(PDO::FETCH_ASSOC))) {
        $novaSituacao = new Situacao($row["id"]);
        $novaSituacao->setNome($row["nome"]);
        $novaSituacao->setCor("#" . $row["cor"]);
        array_push($situacoes, $novaSituacao);
      }
    }
    return $situacoes;
  }
}
