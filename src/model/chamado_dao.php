<?php
require_once("dao.php");
require_once("chamado.php");
require_once("chamado_ti.php");
require_once("alteracao.php");
require_once("tecnico.php");
require_once("usuario.php");
require_once("setor.php");
require_once("problema.php");

class ChamadoDAO extends DAO
{
  private $table = "tchamado";

  protected function read($resultadoDB, $populate = array(), $problema = true)
  {
    $chamados = array();
    $resultadoDB->execute();
    if ($resultadoDB->rowCount() > 0) {
      while (($row = $resultadoDB->fetch(PDO::FETCH_ASSOC))) {
        $novoChamado = new Chamado($row["id"]);
        $novoChamado->setDescricao($row["descricao"]);
        $novoChamado->setData($row["data"]);
        $novoChamado->setTombo($row["tombo"]);
        $novoChamado->setArquivo($row["arquivo"]);
        $alteracao = new Alteracao();
        $alteracao->setChamado($novoChamado);
        $novoChamado->setAlteracoes($alteracao->readAllByChamado());
        // var_dump($novoChamado->getAlteracoes());
        // var_dump($row["id_problema"]);
        // var_dump($row);
        if ($row["id_problema"]) {
          $problema = new Problema();
          $problema->setID($row["id_problema"]);
          $novoChamado->setProblema($problema->read());
        }
        if ($populate["setor"]) {
          $setor = new Setor();
          $setor->setID($row["id_setor"]);
          $novoChamado->setSetor($setor->read($problema));
        }
        if ($populate["tecnico"]) {
          $tecnico = new Tecnico();
          $tecnico->setLogin($row["id_tecnico"]);
          // var_dump($row);
          // var_dump($tecnico);
          $novoChamado->setTecnico($tecnico->read(array("chamados" => false)));
        }
        if ($populate["usuario"]) {
          $usuario = new Usuario();
          $usuario->setCPF($row["id_usuario"]);
          $novoChamado->setUsuario($usuario->read(array("chamados" => false)));
        }

        array_push($chamados, $novoChamado);
      }
    }
    return $chamados;
  }

  public function readByUsuario($usuario)
  {
    $resultadoDB = $this->conn->prepare("SELECT * FROM $this->table WHERE id_usuario = :usuario");
    $resultadoDB->bindValue(":usuario", $usuario->getCPF(), PDO::PARAM_STR);
    return $this->read($resultadoDB, array("tecnico" => true, "usuario" => false, "setor" => true), false);
    // QUERY INCOMPLETA
  }

  public function readByTecnico($tecnico)
  {
    $resultadoDB = $this->conn->prepare("SELECT * FROM $this->table WHERE id_tecnico = :tecnico");
    $resultadoDB->bindValue(":tecnico", $tecnico->getLogin(), PDO::PARAM_STR);
    return $this->read($resultadoDB, array("tecnico" => false, "usuario" => true, "setor" => true));
  }

  public function readByID($chamado, $populate = array())
  {
    $resultadoDB = $this->conn->prepare("SELECT * FROM $this->table WHERE id = :id");
    $resultadoDB->bindValue(":id", $chamado->getID(), PDO::PARAM_INT);
    $resultadoDB->execute();
    if ($resultadoDB->rowCount()) {
      $row = $resultadoDB->fetch(PDO::FETCH_ASSOC);
      $chamado->setDescricao($row["descricao"]);
      $chamado->setData($row["data"]);
      $chamado->setTombo($row["tombo"]);
      $chamado->setArquivo($row["arquivo"]);
      if ($row["id_problema"]) {
        $problema = new Problema();
        $problema->setID($row["id_problema"]);
        $chamado->setProblema($problema->read());
      }
      $alteracao = new Alteracao();
      $alteracao->setChamado($chamado);
      $chamado->setAlteracoes($alteracao->readAllByChamado());
      //   var_dump($chamado->getAlteracoes()[0]->getJSON());
      //   var_dump($chamado->getAlteracoes())
      $setor = new Setor();
      $setor->setID($row["id_setor"]);
      $chamado->setSetor($setor->read());
      if ($populate["tecnico"]) {
        $tecnico = new Tecnico();
        $tecnico->setLogin($row["id_tecnico"]);
        $chamado->setTecnico($tecnico->read(array("chamados" => false)));
      }
      if ($populate["usuario"]) {
        $usuario = new Usuario();
        $usuario->setCPF($row["id_usuario"]);
        $chamado->setUsuario($usuario->read(array("chamados" => false)));
      }
      return $chamado;
    }
    return null;
  }

  public function readBySetor($chamado)
  {
    $resultadoDB = null;
    if (($setor = $chamado->getSetor()) && $setor->getID()) {
      $resultadoDB = $this->conn->prepare(
        "SELECT * FROM $this->table
         WHERE id_setor = :setor
        "
      );
      // var_dump($setor);
      $resultadoDB->bindValue(":setor", $setor->getID(), PDO::PARAM_INT);
    } else {
      $resultadoDB = $this->conn->prepare(
        "SELECT * FROM $this->table"
      );
    }
    // var_dump($chamado);
    return $this->read($resultadoDB, array("tecnico" => true, "usuario" => true, "setor" => true));
  }

  // public function readEmAberto($setor)
  // {
  //   if ($setor) {
  //     $query = "SELECT chamado.id, chamado.descricao, chamado.data, chamado.ti, 
  //                       chamado.tombo, chamado.id_tecnico, chamado.id_usuario,
  //                    chamado.id_setor
  //              FROM tchamado chamado
  //              INNER JOIN talteracao alteracao
  //                 ON chamado.id = alteracao.id_chamado
  //              GROUP BY chamado.id, chamado.descricao, chamado.data, chamado.ti, 
  //                    chamado.tombo, chamado.id_tecnico, chamado.id_usuario,
  //                    chamado.id_setor 
  //              HAVING count(*) = 1 AND chamado.id_setor = :setor
  //        ";
  //     $resultadoDB = $this->conn->prepare($query);
  //     $resultadoDB->bindValue(":setor", $setor->getID(), PDO::PARAM_INT);
  //     // var_dump($setor);
  //     // $resultadoDB->debugDumpParams();
  //   } else {
  //     $query = "SELECT chamado.id, chamado.descricao, chamado.data, chamado.ti, 
  //                       chamado.tombo, chamado.id_tecnico, chamado.id_usuario,
  //                    chamado.id_setor
  //              FROM tchamado chamado
  //              INNER JOIN talteracao alteracao
  //                 ON chamado.id = alteracao.id_chamado
  //              GROUP BY chamado.id, chamado.descricao, chamado.data, chamado.ti, 
  //                    chamado.tombo, chamado.id_tecnico, chamado.id_usuario,
  //                    chamado.id_setor 
  //              HAVING count(*) = 1
  //        ";
  //     $resultadoDB = $this->conn->prepare($query);
  //   }
  //   $resultadoDB->execute();

  //   $chamados = array();
  //   while ($row = $resultadoDB->fetch(PDO::FETCH_ASSOC)) {
  //     $chamado = new Chamado();
  //     $chamado->setID($row["id"]);
  //     $chamado->setDescricao($row["descricao"]);
  //     $chamado->setData($row["data"]);
  //     $chamado->setTombo($row["tombo"]);
  //     $setor = new Setor();
  //     $setor->setID($row["id_setor"]);
  //     $chamado->setSetor($setor->read());
  //     $tecnico = new Tecnico();
  //     $tecnico->setLogin($row["id_tecnico"]);
  //     $chamado->setTecnico($tecnico->read(array("chamados" => false)));
  //     $usuario = new Usuario();
  //     $usuario->setCPF($row["id_usuario"]);
  //     $chamado->setUsuario($usuario->read(array("chamados" => false)));
  //     array_push($chamados, $chamado);
  //   }
  //   return $chamados;
  // }

  public function delete($chamado)
  {
    $resultadoDB = $this->conn->prepare("DELETE FROM $this->table WHERE id = :chamado");
    $resultadoDB->bindValue(":chamado", $chamado->getID(), PDO::PARAM_INT);
    // $resultadoDB->debugDumpParams();
    $resultadoDB->execute();
    return $resultadoDB->rowCount();
  }

  public function create($chamado)
  {
    $resultadoDB = $this->conn->prepare(
      "INSERT INTO $this->table (descricao, data, ti, tombo, id_usuario, id_problema, id_setor, arquivo)
                VALUES (:descricao, :data, :ti, :tombo, :idusuario, :problema, :idsetor, :arquivo)"
    );
    $resultadoDB->bindValue(":descricao", $chamado->getDescricao(), PDO::PARAM_STR);
    $data = Date("Y-m-d H:i:s");
    $resultadoDB->bindParam(":data", $data, PDO::PARAM_STR);
    $resultadoDB->bindValue(":ti", 0, PDO::PARAM_BOOL);
    $resultadoDB->bindValue(":tombo", $chamado->getTombo(), PDO::PARAM_STR);
    $resultadoDB->bindValue(":idusuario", $chamado->getUsuario()->getCPF(), PDO::PARAM_STR);
    $resultadoDB->bindValue(":idsetor", $chamado->getSetor()->getID(), PDO::PARAM_INT);
    $problema = $chamado->getProblema();
    $resultadoDB->bindValue(":problema", $problema ? $problema->getID() : null, PDO::PARAM_INT);
    $resultadoDB->bindValue(":arquivo", $chamado->getArquivo(), PDO::PARAM_STR);
    $resultadoDB->execute();
    if ($resultadoDB->rowCount()) {
      $chamado->setID($this->conn->lastInsertId());
      $alteracao = new Alteracao();
      $alteracao->setChamado($chamado);
      $alteracao->setDescricao("Criação do chamado.");
      $alteracao->setData($data);
      $situacao = new Situacao(1);
      $alteracao->setSituacao($situacao->read());
      $prioridade = new Prioridade(1);
      $alteracao->setPrioridade($prioridade->read());
      if ($alteracao->create()) {
        $chamado->setAlteracoes(array($alteracao));
        return true;
      }
    }
    return false;
  }

  public function update($chamado)
  {
    $resultadoDB = $this->conn->prepare(
      "UPDATE $this->table
      SET ti = :ti, tombo = :tombo,
          id_tecnico = :tecnico, id_setor = :setor
      WHERE id = :chamado"
    );
    $tecnico = $chamado->getTecnico();
    $resultadoDB->bindValue(":chamado", $chamado->getID(), PDO::PARAM_INT);
    $resultadoDB->bindValue(":tombo", $chamado->getTombo(), PDO::PARAM_STR);
    $resultadoDB->bindValue(":tecnico", $tecnico ? $tecnico->getLogin() : null, PDO::PARAM_STR);
    $setor = $chamado->getSetor();
    // var_dump($setor);
    $resultadoDB->bindValue(":setor", $setor->getID(), PDO::PARAM_INT);
    if ($setor->getNome() === 'TI') {
      $resultadoDB->bindValue(":ti", true, PDO::PARAM_BOOL);
    } else {
      $resultadoDB->bindValue(":ti", false, PDO::PARAM_BOOL);
    }
    $resultadoDB->execute();
    return $resultadoDB->rowCount();
  }
}
