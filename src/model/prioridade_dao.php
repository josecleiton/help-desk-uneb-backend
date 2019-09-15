<?php
require_once("dao.php");
require_once("prioridade.php");
class PrioridadeDAO extends DAO
{
  private $table = "tprioridade";
  public function read($prioridade)
  {
    $resultadoDB = null;

    if (($id = $prioridade->getID()) > 0) {
      $resultadoDB = $this->conn->prepare(
        "SELECT * FROM $this->table WHERE id = :id"
      );
      $resultadoDB->bindParam(":id", $id, PDO::PARAM_INT);
    } else {
      $resultadoDB = $this->conn->prepare(
        "SELECT * FROM $this->table WHERE descricao = :descricao"
      );
      $resultadoDB->bindValue(":descricao", $prioridade->getDescricao(), PDO::PARAM_STR);
      // var_dump($prioridade);
      // var_dump($prioridade->getDescricao());
    }
    $resultadoDB->execute();
    if ($resultadoDB->rowCount() == 1) {
      $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
      $prioridade->setDescricao($row["descricao"]);
      $prioridade->setID($row["id"]);
      return $prioridade;
    }
    return false;
  }

  public function readAll()
  {
    $prioridades = array();
    $resultadoDB = $this->conn->prepare(
      "SELECT * FROM tprioridade ORDER BY id"
    );
    $resultadoDB->execute();
    if ($resultadoDB->rowCount()) {
      while ($row = $resultadoDB->fetch(PDO::FETCH_ASSOC)) {
        $novaPrioridade = new Prioridade($row["id"]);
        $novaPrioridade->setDescricao($row["descricao"]);
        array_push($prioridades, $novaPrioridade);
      }
    }
    return $prioridades;
  }
}
