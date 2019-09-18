<?php
require_once("dao.php");
require_once("alteracao.php");
require_once("situacao.php");
require_once("prioridade.php");

class AlteracaoDAO extends DAO
{
  private $table = "talteracao";
  public function readAllByChamado($chamado)
  {
    $query = "SELECT * FROM $this->table WHERE id_chamado = :chamado";
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(":chamado", $chamado->getID(), PDO::PARAM_INT);
    $stmt->execute();
    $alteracoes = array();
    if ($stmt->rowCount() > 0) {
      while (($row = $stmt->fetch(PDO::FETCH_ASSOC))) {
        // extract($row);
        $novaAlteracao = new Alteracao($row["id"]);
        $novaAlteracao->setDescricao($row["descricao"]);
        $novaAlteracao->setData($row["data"]);
        $situacao = new Situacao($row["id_situacao"]);
        $novaAlteracao->setSituacao($situacao->read());
        $prioridade = new Prioridade($row["id_prioridade"]);
        $novaAlteracao->setPrioridade($prioridade->read());
        array_push($alteracoes, $novaAlteracao);
      }
    }
    return $alteracoes;
  }

  public function create($alteracao)
  {
    // var_dump($tecnico);
    $stmt = $this->conn->prepare(
      "INSERT INTO $this->table (data, descricao, id_chamado, id_situacao, id_prioridade, id_tecnico)
                VALUES (:data, :descricao, :idchamado, :idsituacao, :idprioridade, :tecnico)"
    );
    if (!($data = $alteracao->getData())) {
      $data = Date("Y-m-d H:i:s");
    }
    $tecnico = $alteracao->getTecnico();
    $stmt->bindParam(":data", $data, PDO::PARAM_STR);
    $stmt->bindValue(":descricao", $alteracao->getDescricao(), PDO::PARAM_STR);
    $stmt->bindValue(":idchamado", $alteracao->getChamado()->getID(), PDO::PARAM_INT);
    $stmt->bindValue(":idsituacao", $alteracao->getSituacao()->getID(), PDO::PARAM_INT);
    $stmt->bindValue(":idprioridade", $alteracao->getPrioridade()->getID(), PDO::PARAM_INT);
    $stmt->bindValue(":tecnico", $tecnico ? $tecnico->getLogin() : null, PDO::PARAM_STR);
    if ($stmt->execute()) {
      $alteracao->setID($this->conn->lastInsertId());
      return true;
    }
    throw new Exception("Deu ruim");
  }
}
