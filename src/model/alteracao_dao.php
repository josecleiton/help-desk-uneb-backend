<?php
require_once("dao.php");
require_once("alteracao.php");
require_once("situacao.php");
require_once("prioridade.php");

class AlteracaoDAO extends DAO {
   private $table = "talteracao";
   public function readByChamado($chamado) {
      $query = "SELECT * FROM $this->table WHERE id_chamado = :idchamado";
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->bindValue(":idchamado", $chamado->getID(), PDO::PARAM_INT);
      $resultadoDB->execute();
      $alteracoes = array();
      if($resultadoDB->rowCount() > 0) {
         while(($row = $resultadoDB->fetch(PDO::FETCH_ASSOC))) {
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
      // var_dump($alteracoes);
      return $alteracoes;

   }

   public function create($alteracao) {
      $query = "INSERT INTO $this->table (data, descricao, id_chamado, id_situacao, id_prioridade)
                VALUES (:data, :descricao, :idchamado, :idsituacao, :idprioridade)";
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->bindValue(":data", $alteracao->getData(), PDO::PARAM_STR);
      $resultadoDB->bindValue(":descricao", $alteracao->getDescricao(), PDO::PARAM_STR);
      $resultadoDB->bindValue(":idchamado", $alteracao->getChamado()->getID(), PDO::PARAM_INT);
      $resultadoDB->bindValue(":idsituacao", $alteracao->getSituacao()->getID(), PDO::PARAM_INT);
      $resultadoDB->bindValue(":idprioridade", $alteracao->getPrioridade()->getID(), PDO::PARAM_INT);
      if($resultadoDB->execute()) {
         $alteracao->setID($this->conn->lastInsertId());
         return true;
      }
      return false;
   }
}

?>
