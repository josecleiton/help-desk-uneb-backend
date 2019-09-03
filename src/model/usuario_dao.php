<?php
require_once("dao.php");
require_once("chamado_dao.php");

class UsuarioDAO extends DAO {
   const TABLE = "tusuario";

   public function create($usuario) {
   }

   public function read($usuario) {

      $cpfUsuario = $usuario->getCPF();
      $query = "SELECT * FROM " . self::TABLE .
               " WHERE " . (($cpfUsuario) ? ("cpf = " . $cpfUsuario) :
                           ("email = '" . $usuario->getEmail() . "'"));
      // echo $query . "\n";
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->execute();
      if($resultadoDB->rowCount() == 1) {
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         if($cpfUsuario) 
            $usuario->setEmail($row["email"]);
         else
            $usuario->setCPF($row["cpf"]);
         $usuario->setTelefone($row["telefone"]);
         // busque os chamados
         $chamadoDAO = new ChamadoDAO();
         $usuario->setChamados($chamadoDAO->readByUsuario($usuario));
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
