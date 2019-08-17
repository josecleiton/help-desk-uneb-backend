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
      echo $query . "\n";
      $resultadoDB = $this->conn->prepare($query);
      $resultadoDB->execute();
      $encontrado = false;
      if($resultadoDB->rowCount() == 1) {
         $encontrado = true;
         $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
         extract($row);
         if($cpfUsuario) 
            $usuario->setEmail($email);
         else
            $usuario->setCPF($cpf);
         $usuario->setTelefone($telefone);
         // busque os chamados
         $chamadoDAO = new ChamadoDAO();
         $usuario->setChamados($chamadoDAO->readByUsuario($usuario));
      }
      return array($usuario, $encontrado);
   }

   public function update($usuario) {
   }

   public function remove($usuario) {
   }
}

?>
