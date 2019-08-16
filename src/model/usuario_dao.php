<?php
require_once("dao.php");
require_once("chamado_dao.php");

class UsuarioDAO extends DAO {
   const TABLE = "tusuario";

   public function create($usuario) {
   }

   public function read($usuario) {

      $query = "SELECT * FROM " . self::TABLE .
               " WHERE cpf = ". $usuario->getCPF();
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->execute();
      if($resultadoDB->rowCount() == 1) {
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         extract($row);
         $usuario->setEmail($email);
         $usuario->setTelefone($telefone);
         // busque os chamados
         $chamadoDAO = new ChamadoDAO();
         /* $usuario->setChamados($chamadoDAO->readByUsuario($usuario)); */
         return true;
      }
      return false;
   }

   public function update($usuario) {
   }

   public function remove($usuario) {
   }
}

?>
