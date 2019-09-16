<?php

use PHPMailer\PHPMailer\Exception;

require_once "dao.php";
require_once "chamado_dao.php";

class TecnicoDAO extends DAO
{
  protected $table = "ttecnico";
  public function read($tecnico, $spread)
  {
    if (!$tecnico->getLogin()) return $tecnico;
    $resultadoDB = $this->conn->prepare(
      "SELECT * FROM $this->table WHERE login = :login"
    );
    // $login = $tecnico->getLogin();
    $resultadoDB->bindValue(":login", $tecnico->getLogin(), PDO::PARAM_STR);
    $resultadoDB->execute();
    if ($resultadoDB->rowCount() == 1) {
      $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
      $tecnico->setNome($row["nome"]);
      $tecnico->setSenha($row["senha"]);
      $tecnico->setEmail($row["email"]);
      $tecnico->setTelefone($row["telefone"]);
      $setor = new Setor();
      $setor->setID($row["id_setor"]);
      $tecnico->setSetor($setor->read(false));
      if ($spread["chamados"]) {
        $chamadoDAO = new ChamadoDAO();
        $tecnico->setChamados($chamadoDAO->readByTecnico($tecnico));
      }
    }
    return $tecnico;
  }

  public function delete($tecnico)
  {
    $resultadoDB = $this->conn->prepare("DELETE FROM $this->table WHERE login = :login");
    $resultadoDB->bindValue(":login", $tecnico->getLogin(), PDO::PARAM_STR);
    $resultadoDB->execute();
    if ($resultadoDB->rowCount())
      return $tecnico;
    throw new Exception("Erro ao excluir técnico " . $tecnico->getNome());
  }

  public function auth($tecnico, $senha)
  {
    $resultadoDB = $this->conn->prepare("SELECT * FROM $this->table WHERE login = :login");
    $resultadoDB->bindValue(":login", $tecnico->getLogin(), PDO::PARAM_STR);
    $resultadoDB->execute();
    if ($resultadoDB->rowCount()) {
      $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
      if (password_verify($senha, $row["senha"])) {
        $tecnico->setEmail($row["email"]);
        $tecnico->setTelefone($row["telefone"]);
        $tecnico->setNome($row["nome"]);
        $tecnico->setCargo($row["cargo"]);
        $tecnico->setSenha($row["senha"]);
        $setor = new Setor();
        $setor->setID($row["id_setor"]);
        $tecnico->setSetor($setor);
        return true;
      }
    }
    return false;
  }
  public function create($tecnico, $senha)
  {
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
    $tecnico->setSenha($hashedSenha);
    return $resultadoDB->execute();
  }

  public function readAllBySetor($tecnico)
  {

    if (($setor = $tecnico->getSetor()) && $setor->getID()) {
      $resultadoDB = $this->conn->prepare(
        "SELECT tecnico.login, tecnico.nome, tecnico.email, tecnico.telefone,
                tecnico.id_setor, tecnico.cargo, tecnico.senha
        FROM ttecnico tecnico
        INNER JOIN tsetor setor
          ON tecnico.id_setor = setor.id
        WHERE setor.id = :setor"
      );
      $resultadoDB->bindValue(":setor", $setor->getID(), PDO::PARAM_INT);
      // var_dump($setor);
    } else {
      $resultadoDB = $this->conn->prepare(
        "SELECT tecnico.login, tecnico.nome, tecnico.email, tecnico.telefone,
                tecnico.id_setor, tecnico.cargo, tecnico.senha
        FROM ttecnico tecnico"
      );

      // echo "KKKKKA";
    }
    $resultadoDB->execute();
    $tecnicos = array();
    if ($resultadoDB->rowCount() > 0) {
      while (($row = $resultadoDB->fetch(PDO::FETCH_ASSOC))) {
        $novoTecnico = new Tecnico();
        $novoTecnico->setLogin($row["login"]);
        $novoTecnico->setNome($row["nome"]);
        $novoTecnico->setEmail($row["email"]);
        $novoTecnico->setTelefone($row["telefone"]);
        $novoTecnico->setSenha($row["senha"]);
        if ($row["id_setor"]) {
          $setor = new Setor();
          $setor->setID($row["id_setor"]);
          $novoTecnico->setSetor($setor->read());
        }
        $novoTecnico->setCargo($row["cargo"]);
        // var_dump($novoTecnico);
        array_push($tecnicos, $novoTecnico);
      }
      // echo "KKKK";
    }
    return $tecnicos;
  }

  public function update($tecnico)
  {
    $resultadoDB = $this->conn->prepare(
      "UPDATE $this->table
       SET nome = :nome, email = :email, telefone = :telefone, id_setor = :setor, senha = :senha
       WHERE login = :tecnico
      "
    );
    $setor = $tecnico->getSetor();
    $resultadoDB->bindValue(":nome", $tecnico->getNome(), PDO::PARAM_STR);
    $resultadoDB->bindValue(":email", $tecnico->getEmail(), PDO::PARAM_STR);
    $resultadoDB->bindValue(":telefone", $tecnico->getTelefone(), PDO::PARAM_STR);
    $resultadoDB->bindValue(":setor", $setor ? $setor->getID() : null);
    $resultadoDB->bindValue(":senha", $tecnico->getSenha(), PDO::PARAM_STR);
    $resultadoDB->bindValue(":tecnico", $tecnico->getLogin(), PDO::PARAM_STR);
    $resultadoDB->execute();
    if ($resultadoDB->rowCount()) {
      return true;
    } else {
      throw new Exception("Falha na atualização do técnico");
    }
  }
}
