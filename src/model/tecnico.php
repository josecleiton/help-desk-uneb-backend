<?php
require_once "usuario.php";
require_once "tecnico_dao.php";
require_once "chamado.php";
require_once dirname(__FILE__) . "/../config/env.php";
require_once dirname(__file__) . "/../vendor/autoload.php";

use \Firebase\JWT\JWT;

class Tecnico extends Usuario
{
  protected $login;
  protected $setor;
  protected $chamados;
  protected $cargo;
  protected $senha;

  public function getLogin()
  {
    return $this->login;
  }

  public function getSetor()
  {
    if ($this->setor || $this->cargo === 'A') {
      return $this->setor;
    } else {
      $setor = new Setor();
      $this->setSetor(($setor->readByTecnico($this) ? $setor : null));
      return $this->setor;
    }
  }

  public function getChamados()
  {
    if ($this->chamados) {
      return $this->chamados;
    } else {
      $chamadoDAO = new ChamadoDAO();
      $this->setChamados($chamadoDAO->readByTecnico($this));
      return $this->chamados;
    }
  }

  public function getChamadosBySituacao($situacao)
  {
    // var_dump($situacao);
    $chamados = array();
    foreach ($this->getChamados() as $chamado) {
      if ($chamado->getSituacao()->getNome() === $situacao->getNome())
        array_push($chamados, $chamado);
    }
    return $chamados;
  }

  public function getChamadosSetorBySituacao($situacao)
  {
    $ch = new Chamado();
    $ch->setSetor($this->setor);
    // var_dump($ch);
    // $payload = $ch->readBySetor();
    // var_dump($payload);
    // return [];
    $chamados = array();
    if ($situacao->getNome() === 'Em Aberto') {
      // echo "KKKKK";
      // var_dump($ch);
      foreach ($ch->readBySetor() as $item) {
        // var_dump($item->getSituacao());
        // var_dump($item);

        $itemSituacao = $item->getSituacao();
        // var_dump($item->getTecnico());
        // var_dump($itemSituacao);
        // var_dump($item);
        if (
          $itemSituacao->getNome() === $situacao->getNome() ||
          !$item->getTecnico() || ($itemSituacao->getNome() === 'Transferido' && $item->getTecnico()->getLogin() === $this->login)
        )
          array_push($chamados, $item);
      }
    } else {
      foreach ($ch->readBySetor() as $item) {
        // var_dump($item->getSituacao());
        // var_dump($item);
        if ($item->getSituacao()->getNome() === $situacao->getNome())
          array_push($chamados, $item);
      }
    }
    return $chamados;
  }

  public function getChamadosJSON($nullVal)
  {
    return array_map(function ($chamado) use ($nullVal) {
      return $chamado->getJSON($nullVal);
    }, $this->getChamados());
  }

  public function getCargo()
  {
    return $this->cargo;
  }

  public function getJSON($nullVal = array())
  {
    $setor = $this->getSetor();
    // var_dump($this);
    return array(
      "nome" => $this->getNome(),
      "login" => $this->getLogin(),
      "email" => $this->getEmail(),
      "telefone" => $this->getTelefone(),
      "cargo" => $this->cargo ? $this->cargo : 'T',
      "setor" => array_key_exists("setor", $nullVal) ? null : $setor ? $this->getSetor()->getJSON() : null,
      "chamados" => array_key_exists("chamados", $nullVal) ? null : $this->getChamadosJSON(array("tecnico" => true)),
    );
  }

  public function setLogin($login)
  {
    $this->login = $login;
  }
  public function setSenha($senha)
  {
    $this->senha = $senha;
  }
  public function setSetor($setor)
  {
    $this->setor = $setor;
  }
  public function setCargo($cargo)
  {
    $this->cargo = $cargo;
  }

  public function setChamados($chamados)
  {
    $this->chamados = $chamados;
  }

  public function read($spread = array())
  {
    $dao = new TecnicoDAO();
    return $dao->read($this, $spread);
  }

  public function readAllBySetor()
  {
    $dao = new TecnicoDAO();
    return $dao->readAllBySetor($this);
  }

  public function login($senha)
  {
    $dao = new TecnicoDAO();
    return $dao->auth($this, $senha);
  }

  public function toJWT()
  {
    if ($this->setor) {
      $setor = $this->setor->getID();
    }
    $token = array(
      "nome" => $this->getNome(),
      "login" => $this->getLogin(),
      "senha" => $this->senha,
      "email" => $this->getEmail(),
      "cargo" => $this->getCargo(),
      "telefone" => $this->getTelefone(),
      "setor" => $setor,
      "logado_em" => time(),
    );
    return array($token, JWT::encode($token, ENV::getAppKey()));
  }

  public static function readJWT($jwt)
  {
    //  var_dump($jwt);
    try {
      return JWT::decode($jwt, ENV::getAppKey(), array('HS256'));
    } catch (\Exception $e) {
      return false;
    }
  }

  public static function readJWTAndSet($jwt, $tecnico)
  {

    // var_dump("TEST");
    if (!($decoded = self::readJWT($jwt)))
      return false;
    $tecnico->setNome($decoded->nome);
    $tecnico->setLogin($decoded->login);
    $tecnico->setSenha($decoded->senha);
    $tecnico->setEmail($decoded->email);
    $tecnico->setCargo($decoded->cargo);
    $setor = new Setor();
    $setor->setID($decoded->setor);
    $tecnico->setSetor($setor);
    return $tecnico;
  }

  public function create()
  {
    $dao = new TecnicoDAO();
    return $dao->create($this, $this->senha);
  }

  public function delete()
  {
    $dao = new TecnicoDAO();
    return $dao->delete($this);
  }

  public function auth()
  {
    $dao = new TecnicoDAO();
    return $dao->auth($this, $this->senha);
  }

  public function cadastraAlteracao($alteracao)
  {
    return $alteracao->create($this);
  }

  public function atendeChamado($chamado)
  { }

  public function encaminhaChamado($chamado, $setor)
  { }

  public function concluiChamado($chamado)
  { }

  public function alteraSituacao($chamado, $situacao, $alteracao)
  { }
}
