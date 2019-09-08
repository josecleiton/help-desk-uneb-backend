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

   public function auth($tecnico, $senha) {
      $resultadoDB = $this->conn->prepare("SELECT * FROM $this->table WHERE login = :login");
      $resultadoDB->bindValue(":login", $tecnico->getLogin(), PDO::PARAM_STR);
      $resultadoDB->execute();
      if($resultadoDB->rowCount()) {
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         if(password_verify($senha, $row["senha"])) {
            $tecnico->setEmail($row["email"]);
            $tecnico->setTelefone($row["telefone"]);
            $tecnico->setNome($row["nome"]);
            $tecnico->setCargo($row["cargo"]);
            $tecnico->setSenha($row["senha"]);
            return true;
         }
      }
      return false;
   }
   public function create($tecnico, $senha) {
      $query = "INSERT INTO $this->table (login, nome, email, telefone, id_setor, senha)
                VALUES (:login, :nome, :email, :telefone, :setor, :senha)";

      // var_dump($tecnico);
      // $setor = $tecnico->getSetor()->getID();
      // var_dump($tecnico->getSetor());
      // var_dump($setor);
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->bindValue(":login", $tecnico->getLogin(), PDO::PARAM_STR);
      $resultadoDB->bindValue(":nome", $tecnico->getNome(), PDO::PARAM_STR);
      $resultadoDB->bindValue(":email", $tecnico->getEmail(), PDO::PARAM_STR);
      $resultadoDB->bindValue(":telefone", $tecnico->getTelefone(), PDO::PARAM_STR);
      $resultadoDB->bindValue(":setor", $tecnico->getSetor()->getID(), PDO::PARAM_INT);
      $hashedSenha = password_hash($senha, PASSWORD_BCRYPT, ['cost' => 12]);
      // var_dump($hashedSenha);
      $resultadoDB->bindParam(":senha", $hashedSenha, PDO::PARAM_STR);
      $resultadoDB->execute();
      $tecnico->setSenha($hashedSenha);
      return $resultadoDB->rowCount();
   }
}
