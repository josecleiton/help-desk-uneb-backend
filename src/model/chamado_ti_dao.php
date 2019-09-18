<?php
require_once("chamado_dao.php");

class ChamadoTIDAO extends ChamadoDAO
{
  private $table = "tchamado_ti";
  public function create($chamado)
  {
    $stmt = $this->conn->prepare(
      "UPDATE tchamado SET ti = 1 WHERE id = :id"
    );
    $id = $chamado->getID();
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    if (!$stmt->rowCount()) return false;
    $stmt = $this->conn->prepare(
      "INSERT INTO $this->table
       VALUES (:software, :data,
                :link, :plugins,
               :chamado, :lab)
      "
    );
    $stmt->bindValue(":software", $chamado->getSoftware(), PDO::PARAM_STR);
    $stmt->bindValue(":data", $chamado->getDataUtilizacao(), PDO::PARAM_STR);
    $stmt->bindValue(":link", $chamado->getLink(), PDO::PARAM_STR);
    $stmt->bindValue(":plugins", $chamado->getPlugins(), PDO::PARAM_STR);
    $stmt->bindParam(":chamado", $id, PDO::PARAM_INT);
    $stmt->bindValue(":lab", $chamado->getSala(), PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->rowCount();
  }

  public function read($chamado)
  {
    $stmt = $this->conn->prepare(
      "SELECT ti FROM tchamado WHERE id = :id"
    );
    $id = $chamado->getID();
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount()) {
      // var_dump($chamado);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($row["ti"]) {
        $stmt = $this->conn->prepare(
          "SELECT * FROM $this->table WHERE id_chamado = $id"
        );
        $stmt->execute();
        if ($stmt->rowCount()) {
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
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
