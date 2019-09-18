<?php

require_once("dao.php");
require_once("setor.php");

class ProblemaDAO extends DAO
{
  private $table = "tproblema";

  public function create($problema)
  {
    $stmt = $this->conn->prepare(
      "INSERT INTO $this->table (descricao, id_setor)
              VALUES (:descricao, :setor)"
    );
    $stmt->bindValue(":descricao", $problema->getDescricao(), PDO::PARAM_STR);
    $stmt->bindValue(":setor", $problema->getSetor()->getID(), PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function read($problema)
  {
    if ($problema->getID()) {
      $stmt = $this->conn->prepare(
        "SELECT * FROM $this->table
       WHERE id = :id"
      );
      // var_dump($problema);
      $stmt->bindValue(":id", $problema->getID(), PDO::PARAM_INT);
      $stmt->execute();
      if ($stmt->rowCount()) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $problema->setDescricao($row["descricao"]);
        $setor = new Setor();
        $setor->setID($row["id_setor"]);
        $problema->setSetor($setor->read(false));
        return $problema;
      }
    } else {
      $stmt = $this->conn->prepare(
        "SELECT id FROM $this->table
         WHERE descricao = :descricao AND id_setor = :setor
        "
      );
      $stmt->bindValue(":descricao", $problema->getDescricao(), PDO::PARAM_STR);
      $stmt->bindValue(":setor", $problema->getSetor()->getID(), PDO::PARAM_INT);
      $stmt->execute();
      if ($stmt->rowCount()) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $problema->setID($row["id"]);
        return $problema;
      }
    }
  }

  public function readAllBySetor($problema, $populate)
  {
    // var_dump($nullVal);
    $setor = $problema->getSetor();
    $stmt = $this->conn->prepare(
      "SELECT id, descricao
       FROM $this->table
       WHERE id_setor = :setor"
    );
    $stmt->bindValue(":setor", $setor->getID(), PDO::PARAM_INT);
    $problemas = array();
    if ($stmt->execute() && $stmt->rowCount()) {
      while (($row = $stmt->fetch(PDO::FETCH_ASSOC))) {
        $novoProblema = new Problema();
        $novoProblema->setID($row["id"]);
        $novoProblema->setDescricao($row["descricao"]);
        if ($populate["setor"])
          $novoProblema->setSetor($setor);
        array_push($problemas, $novoProblema);
      }
    }
    return $problemas;
  }

  public function delete($problema)
  {
    $stmt = $this->conn->prepare(
      "DELETE FROM $this->table
       WHERE id = :problema"
    );
    // var_dump($problema);
    $stmt->bindValue(":problema", $problema->getID(), PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount();
  }
}
