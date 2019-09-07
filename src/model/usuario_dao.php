<?php
require_once("dao.php");
require_once("chamado_dao.php");

class UsuarioDAO extends DAO {

   public function create($usuario) {
      $query = "INSERT INTO tusuario (cpf, nome, email, telefone) VALUES (:cpf, :nome, :email, :telefone)";
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->bindValue(":cpf", $usuario->getCPF(), PDO::PARAM_STR, 11);
      $resultadoDB->bindValue(":nome", $usuario->getNome(), PDO::PARAM_STR, 80);
      $resultadoDB->bindValue(":email", $usuario->getEmail(), PDO::PARAM_STR, 80);
      $resultadoDB->bindValue(":telefone", $usuario->getTelefone(), PDO::PARAM_STR, 11);
      $resultadoDB->execute();
      return $resultadoDB->rowCount() == 1;
   }

   public function existe($usuario) {
      $query = "SELECT * FROM tusuario WHERE email = :email OR cpf = :cpf";
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->bindValue(":email", $usuario->getEmail(), PDO::PARAM_STR, 80);
      $resultadoDB->bindValue(":cpf", $usuario->getCPF(), PDO::PARAM_STR, 11);
      // var_dump($resultadoDB->debugDumpParams());
      $resultadoDB->execute();
      return $resultadoDB->rowCount() == 1;
   }

   public function read($usuario, $spread) {

      $cpfUsuario = $usuario->getCPF();
      // $query = "SELECT * FROM tusuario " . 
      //          " WHERE " . (($cpfUsuario) ? ("cpf = " . $cpfUsuario) :
      //                      ("email = '" . $usuario->getEmail() . "'"));
      $resultadoDB = null;
      if($cpfUsuario) {
         $query = "SELECT * FROM tusuario WHERE cpf = :cpf";
         $resultadoDB = $this->conn->prepare($query);
         $resultadoDB->bindParam(":cpf",  $cpfUsuario, PDO::PARAM_STR, 11);
      } else {
         $query = "SELECT * FROM tusuario WHERE email = :email";
         $resultadoDB = $this->conn->prepare($query);
         $resultadoDB->bindValue(":email",  $usuario->getEmail(), PDO::PARAM_STR, 11);
      }
      // $resultadoDB->debugDumpParams();
      $resultadoDB->execute();
      if($resultadoDB->rowCount() == 1) {
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         if($cpfUsuario) 
            $usuario->setEmail($row["email"]);
         else
            $usuario->setCPF($row["cpf"]);
         $usuario->setTelefone($row["telefone"]);
         $usuario->setNome($row["nome"]);
         // busque os chamados
         if($spread["chamados"]) {
            $chamadoDAO = new ChamadoDAO();
            $usuario->setChamados($chamadoDAO->readByUsuario($usuario));
         }
         return $usuario;
      }
      return false;
   }

   public function update($usuario) {
   }

   public function remove($usuario) {
   }
}

?>
