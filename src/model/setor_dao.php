<?php
require_once("dao.php");
require_once("setor.php");
require_once("problema.php");

class SetorDAO extends DAO
{
  private $table = "tsetor";

  protected function readOne($setor, $stmt, $populateProblema)
  {
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if (array_key_exists("nome", $row)) {
        $setor->setNome($row["nome"]);
      }
      if (array_key_exists("id", $row)) {
        $setor->setID($row["id"]);
      }
      $setor->setTelefone($row["telefone"]);
      $setor->setEmail($row["email"]);
      if ($populateProblema) {
        $problema = new Problema();
        $problema->setSetor($setor);
        $setor->setProblemas($problema->readAllBySetor(array("setor" => false)));
      }
      return $setor;
    }
    return false;
  }

  public function create($setor)
  {

    $query = "INSERT INTO $this->table (nome, telefone, email) values (:nome, :telefone, :email)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue("nome", $setor->getNome(), PDO::PARAM_STR);
    $stmt->bindValue("email", $setor->getEmail(), PDO::PARAM_STR);
    $stmt->bindValue("telefone", $setor->getTelefone(), PDO::PARAM_STR);
    if ($stmt->execute()) {
      $setor->setID($this->conn->lastInsertId());
      return $stmt->rowCount();
    }
    return 0;
  }

  public function readByID($setor, $problema)
  {
    // $query = "SELECT nome, telefone, email FROM " . self::TABLE .
    //          " WHERE id = " . $setor->getID();
    $stmt = $this->conn->prepare("SELECT nome, telefone, email FROM $this->table WHERE id = :id");
    $stmt->bindValue(":id", $setor->getID(), PDO::PARAM_INT);
    return $this->readOne($setor, $stmt, $problema);
  }

  public function readByNome($setor, $problema)
  {
    $stmt = $this->conn->prepare("SELECT id,telefone, email FROM $this->table WHERE nome = :nome");
    $stmt->bindValue(":nome", $setor->getNome(), PDO::PARAM_STR);
    return $this->readOne($setor, $stmt, $problema);
  }

  public function readByTecnico($setor, $tecnico)
  {
    // $query = "SELECT nome, telefone, email FROM " . self::TABLE .
    //          " WHERE id_tecnico = " . $tecnico->getID();

    $query = "SELECT setor.id, setor.nome, setor.telefone, setor.email 
               FROM ttecnico tecnico 
               INNER JOIN tsetor setor
                  ON tecnico.id_setor = setor.id
               WHERE tecnico.login = :tecnico
      ";
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(":tecnico", $tecnico->getLogin());
    // var_dump($tecnico);
    // return null;
    $stmt->execute();
    if ($stmt->rowCount()) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $setor->setID($row["id"]);
      $setor->setNome($row["nome"]);
      $setor->setTelefone($row["telefone"]);
      $setor->setEmail($row["email"]);
      $problema = new Problema();
      $problema->setSetor($setor);
      $setor->setProblemas($problema->readAllBySetor(array("setor" => true)));
      return $setor;
    }
    // var_dump($setor);
    return null;
  }

  public function readAll()
  {
    $query = "SELECT * FROM $this->table";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $setores = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $setor = new Setor();
      $setor->setID($row["id"]);
      $setor->setNome($row["nome"]);
      $setor->setTelefone($row["telefone"]);
      $setor->setEmail($row["email"]);
      $problema = new Problema();
      $problema->setSetor($setor);
      $setor->setProblemas($problema->readAllBySetor(array("setor" => true)));
      array_push($setores, $setor);
    }
    return $setores;
  }
  public function readProblemas($setor)
  { }
  public function delete($setor)
  {
    // $query = "DELETE FROM " . self::TABLE . " WHERE nome = " . $setor->getNome();
    $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE nome = :nome");
    $stmt->bindValue(":nome", $setor->getNome());
    $stmt->execute();
    return $stmt->rowCount();
  }
  public function update($setor)
  {
    $stmt = $this->conn->prepare(
      "UPDATE $this->table 
      SET nome = :nome, email = :email, telefone = :telefone
      WHERE id = :setor"
    );
    $stmt->bindValue(":nome", $setor->getNome(), PDO::PARAM_STR);
    $stmt->bindValue(":email", $setor->getEmail(), PDO::PARAM_STR);
    $stmt->bindValue(":telefone", $setor->getTelefone(), PDO::PARAM_STR);
    $stmt->bindValue(":setor", $setor->getID(), PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount();
  }
}
