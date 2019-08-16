<?php
require_once("dao.php");
require_once("alteracao.php");
require_once("situacao.php");
require_once("prioridade.php");

class AlteracaoDAO extends DAO {
   const TABLE = "talteracao";
   public function readByChamado($chamado) {
      $query = "SELECT * FROM " . self::TABLE .
               " WHERE id_chamado = " . $chamado->getID();
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->execute();
      $alteracoes = array();
      if($resultadoDB->rowCount() > 0) {
         while(($row = $resultadoDB->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $novaAlteracao = new Alteracao($id);
            $novaAlteracao->setDescricao($descricao);
            $novaAlteracao->setData($data);

            $situacao = new Situacao($id_situacao);
            $novaAlteracao->setSituacao($situacao->read());

            $prioridade = new Prioridade($id_prioridade);
            $novaAlteracao->setPrioridade($prioridade->read());
            array_push($alteracoes, $novaAlteracao);
         }
      }
      return $alteracoes;

   }
}

?>
