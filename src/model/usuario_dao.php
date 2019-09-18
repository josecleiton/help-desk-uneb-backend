<?php
require_once("dao.php");
require_once("chamado_dao.php");

class UsuarioDAO extends DAO
{

  private $table = "tusuario";
  public function create($usuario)
  {

    $query = "INSERT INTO $this->table (cpf, nome, email, telefone) VALUES (:cpf, :nome, :email, :telefone)";
    $stmt = $this->conn->prepare($query);
    // var_dump($usuario);
    $stmt->bindValue(":cpf", $usuario->getCPF(), PDO::PARAM_STR);
    $stmt->bindValue(":nome", $usuario->getNome(), PDO::PARAM_STR);
    $stmt->bindValue(":email", $usuario->getEmail(), PDO::PARAM_STR);
    $stmt->bindValue(":telefone", $usuario->getTelefone(), PDO::PARAM_STR);
    return $stmt->execute();
    // return $stmt->rowCount() == 1;
  }

  public function existe($usuario)
  {
    $query = "SELECT * FROM $this->table WHERE email = :email AND cpf = :cpf";
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(":email", $usuario->getEmail(), PDO::PARAM_STR);
    $stmt->bindValue(":cpf", $usuario->getCPF(), PDO::PARAM_STR);
    // var_dump($stmt->debugDumpParams());
    $stmt->execute();
    return $stmt->rowCount() == 1;
  }

  public function read($usuario, $spread)
  {

    $cpfUsuario = $usuario->getCPF();
    // $query = "SELECT * FROM tusuario " . 
    //          " WHERE " . (($cpfUsuario) ? ("cpf = " . $cpfUsuario) :
    //                      ("email = '" . $usuario->getEmail() . "'"));
    $stmt = null;
    if ($cpfUsuario) {
      $stmt = $this->conn->prepare(
        "SELECT * FROM $this->table WHERE cpf = :cpf"
      );
      $stmt->bindParam(":cpf",  $cpfUsuario, PDO::PARAM_STR);
    } else {
      $stmt = $this->conn->prepare(
        "SELECT * FROM $this->table WHERE email = :email"
      );
      $stmt->bindValue(":email",  $usuario->getEmail(), PDO::PARAM_STR);
    }
    // $stmt->debugDumpParams();
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($cpfUsuario)
        $usuario->setEmail($row["email"]);
      else
        $usuario->setCPF($row["cpf"]);
      $usuario->setTelefone($row["telefone"]);
      $usuario->setNome($row["nome"]);
      // busque os chamados
      if ($spread["chamados"]) {
        $chamadoDAO = new ChamadoDAO();
        $usuario->setChamados($chamadoDAO->readByUsuario($usuario));
      }
      return $usuario;
    }
    return false;
  }

  // public function update($usuario) {
  // }

  // public function delete($usuario) {
  // }
}
