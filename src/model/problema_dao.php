<?php

require_once("dao.php");
require_once("setor.php");

class ProblemaDAO extends DAO
{
  private $table = "tproblema";

  public function create($problema)
  {
    $resultadoDB = $this->conn->prepare(
      "INSERT INTO $this->table (descricao, id_setor)
              VALUES (:descricao, :setor)"
    );
    $resultadoDB->bindValue(":descricao", $problema->getDescricao(), PDO::PARAM_STR);
    $resultadoDB->bindValue(":setor", $problema->getSetor()->getID(), PDO::PARAM_INT);
    return $resultadoDB->execute();
  }

  public function read($problema)
  {
    $resultadoDB = $this->conn->prepare(
      "SELECT * FROM $this->table
       WHERE id = :id"
    );
    // var_dump($problema);
    $resultadoDB->bindValue(":id", $problema->getID(), PDO::PARAM_INT);
    $resultadoDB->execute();
    if ($resultadoDB->rowCount()) {
      $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
      $problema->setDescricao($row["descricao"]);
      $setor = new Setor();
      $setor->setID($row["id_setor"]);
      $problema->setSetor($setor->read(false));
      return $problema;
    }
  }

  public function readAllBySetor($problema, $populate)
  {
    // var_dump($nullVal);
    $setor = $problema->getSetor();
    $resultadoDB = $this->conn->prepare(
      "SELECT id, descricao
       FROM $this->table
       WHERE id_setor = :setor"
    );
    $resultadoDB->bindValue(":setor", $setor->getID(), PDO::PARAM_INT);
    if ($resultadoDB->execute() && $resultadoDB->rowCount()) {
      $problemas = array();
      while (($row = $resultadoDB->fetch(PDO::FETCH_ASSOC))) {
        $novoProblema = new Problema();
        $novoProblema->setID($row["id"]);
        $novoProblema->setDescricao($row["descricao"]);
        if ($populate["setor"])
          $novoProblema->setSetor($setor);
        array_push($problemas, $novoProblema);
      }
      return $problemas;
    }
    return null;
  }
}
