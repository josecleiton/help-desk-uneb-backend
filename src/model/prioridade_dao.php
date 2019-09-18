<?php
require_once("dao.php");
require_once("prioridade.php");
class PrioridadeDAO extends DAO
{
  private $table = "tprioridade";
  public function read($prioridade)
  {
    $stmt = null;

    if (($id = $prioridade->getID()) > 0) {
      $stmt = $this->conn->prepare(
        "SELECT * FROM $this->table WHERE id = :id"
      );
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    } else {
      $stmt = $this->conn->prepare(
        "SELECT * FROM $this->table WHERE descricao = :descricao"
      );
      $stmt->bindValue(":descricao", $prioridade->getDescricao(), PDO::PARAM_STR);
      // var_dump($prioridade);
      // var_dump($prioridade->getDescricao());
    }
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $prioridade->setDescricao($row["descricao"]);
      $prioridade->setID($row["id"]);
      return $prioridade;
    }
    return false;
  }

  public function readAll()
  {
    $prioridades = array();
    $stmt = $this->conn->prepare(
      "SELECT * FROM tprioridade ORDER BY id"
    );
    $stmt->execute();
    if ($stmt->rowCount()) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $novaPrioridade = new Prioridade($row["id"]);
        $novaPrioridade->setDescricao($row["descricao"]);
        array_push($prioridades, $novaPrioridade);
      }
    }
    return $prioridades;
  }
}
