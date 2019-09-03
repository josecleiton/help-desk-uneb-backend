<?php
require_once("dao.php");
require_once("chamado.php");
require_once("alteracao_dao.php");
require_once("tecnico.php");
require_once("setor.php");

class ChamadoDAO extends DAO {
   const TABLE = "tchamado";

   protected function read($query) {
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->execute();
      $chamados = array();
      if($resultadoDB->rowCount() > 0) {
         while(($row = $resultadoDB->fetch(PDO::FETCH_ASSOC))) {
            $novoChamado = new Chamado($row["id"]);
            $novoChamado->setDescricao($row["descricao"]);
            $novoChamado->setData($row["data"]);
            $novoChamado->setTombo($row["tombo"]);
            $alteracaoDAO = new AlteracaoDAO();
            $alteracaoDAO->readByChamado($novoChamado);
            $novoChamado->setAlteracoes($alteracaoDAO->readByChamado($novoChamado));
            $setor = new Setor();
            $setor->setID($row["id_setor"]);
            $tecnico = new Tecnico();
            $tecnico->setLogin($row["id_tecnico"]);
            $novoChamado->setSetor($setor->read());
            $novoChamado->setTecnico($tecnico->read());
            array_push($chamados, $novoChamado);
         }
      }
      return $chamados;
   }

   public function readByUsuario($usuario) {
      $query = "SELECT * FROM " . self::TABLE .
               " WHERE id_usuario = " . $usuario->getCPF();
      return $this->read($query);
      // QUERY INCOMPLETA
   }

   public function readByTecnico($tecnico) {
      $query = "SELECT * FROM " . self::TABLE .
         " WHERE id_tecnico = '" . $tecnico->getLogin() . "'";
      return $this->read($query);
   }
}

?>
