<?php
require_once("dao.php");
require_once("chamado_dao.php");

class TecnicoDAO extends DAO {
   private $table = "ttecnico";
   public function read($tecnico, $spread) {
      $query = "SELECT * FROM $this->table WHERE login = :logintec";
      $resultadoDB = $this->conn->prepare($query);
      $login = $tecnico->getLogin();
      // var_dump($login);
      $resultadoDB->bindParam(":logintec", $login);
      $resultadoDB->execute();
      if($resultadoDB->rowCount() == 1) {
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         $tecnico->setNome($row["nome"]);
         $tecnico->setEmail($row["email"]);
         $tecnico->setTelefone($row["telefone"]);
         if($spread["chamados"]) {
            $chamadoDAO = new ChamadoDAO();
            $tecnico->setChamados($chamadoDAO->readByTecnico($this));
         }
      }
      return $tecnico;
   }
}
