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
}

?>
