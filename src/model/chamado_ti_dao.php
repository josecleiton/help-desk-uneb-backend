<?php
require_once("chamado_dao.php");

class ChamadoTIDAO extends ChamadoDAO
{
  private $table = "tchamado_ti";
  public function create($chamado)
  {
    $resultadoDB = $this->conn->prepare(
      "UPDATE tchamado SET ti = 1 WHERE id = :id"
    );
    $id = $chamado->getID();
    $resultadoDB->bindParam(":id", $id, PDO::PARAM_INT);
    $resultadoDB->execute();
    if (!$resultadoDB->rowCount()) return false;
    $resultadoDB = $this->conn->prepare(
      "INSERT INTO $this->table
       VALUES (:software, :data,
                :link, :plugins,
               :chamado, :lab)
      "
    );
    $resultadoDB->bindValue(":software", $chamado->getSoftware(), PDO::PARAM_STR);
    $resultadoDB->bindValue(":data", $chamado->getDataUtilizacao(), PDO::PARAM_STR);
    $resultadoDB->bindValue(":link", $chamado->getLink(), PDO::PARAM_STR);
    $resultadoDB->bindValue(":plugins", $chamado->getPlugins(), PDO::PARAM_STR);
    $resultadoDB->bindParam(":chamado", $id, PDO::PARAM_INT);
    $resultadoDB->bindValue(":lab", $chamado->getSala(), PDO::PARAM_INT);

    $resultadoDB->execute();
    return $resultadoDB->rowCount();
  }

  public function read($chamado)
  {
    $resultadoDB = $this->conn->prepare(
      "SELECT ti FROM tchamado WHERE id = :id"
    );
    $id = $chamado->getID();
    $resultadoDB->bindParam(":id", $id, PDO::PARAM_INT);
    $resultadoDB->execute();
    if ($resultadoDB->rowCount()) {
      // var_dump($chamado);
      $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
      if ($row["ti"]) {
        $resultadoDB = $this->conn->prepare(
          "SELECT * FROM $this->table WHERE id_chamado = $id"
        );
        $resultadoDB->execute();
        if ($resultadoDB->rowCount()) {
          $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
          // echo json_encode($row);
          $chamado->setSoftware($row["software"]);
          $chamado->setDataUtilizacao($row["data_utilizacao"]);
          $chamado->setLink($row["link"]);
          $chamado->setSala($row["sala"]);
          $chamado->setPlugins($row["plugins"]);
          // var_dump($chamado);
        }
      }
    }
    return $chamado;
  }
}
