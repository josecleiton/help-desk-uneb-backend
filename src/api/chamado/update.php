<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__) .  '/../../model/request.php');
require_once(dirname(__FILE__) .  '/../../model/chamado.php');
require_once(dirname(__FILE__) .  '/../../model/tecnico.php');
require_once(dirname(__FILE__) .  '/../../model/situacao.php');
require_once(dirname(__FILE__) .  '/../../model/setor.php');
require_once(dirname(__FILE__) .  '/../../model/alteracao.php');
require_once(dirname(__FILE__) .  '/../../model/prioridade.php');

if (!Tecnico::readJWTAndSet(Request::getAuthToken(), $tecnico = new Tecnico())) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Você não está autenticado",
  ));
  return false;
}

$data = json_decode(file_get_contents("php://input"));

if (empty($data->id) || empty($data->situacao) || empty($data->nova_situacao) || empty($data->prioridade)) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Nem todos os campos foram preenchidos",
  ));
  return false;
}


$prioridade = new Prioridade();
$prioridade->setDescricao($data->prioridade);
if (!$prioridade->read()) {
  echo json_encode(array(
    "error" => 404,
    "mensagem" => "Prioridade não cadastrada.",
  ));
  return false;
}
$situacaoAntes = new Situacao();
$situacaoAntes->setNome($data->situacao);
$situacaoDepois = new Situacao();
$situacaoDepois->setNome($data->nova_situacao);
if (!$situacaoAntes->read() || !$situacaoDepois->read()) {
  echo json_encode(array(
    "error" => 404,
    "mensagem" => "Situações inválidas",
  ));
  return false;
}
$chamado = new Chamado($data->id);
if ($chamado->read(array("tecnico" => true, "usuario" => false))) {
  // var_dump($chamado);
  if ($chamado->getAlteracao()->getSituacao()->getNome() !== $situacaoAntes->getNome()) {
    echo json_encode(array(
      "error" => 400,
      "mensagem" => "Inconsistência nas situações",
    ));
    return false;
  }
  $setor = $chamado->getSetor();
  // var_dump($setor);
  $tecnicoCh = $chamado->getTecnico();
  $alteracao = new Alteracao();
  $alteracao->setPrioridade($prioridade);
  $alteracao->setSituacao($situacaoDepois);
  $alteracao->setChamado($chamado);
  $alteracao->setDescricao($data->descricao);
  if (Situacao::validaMudancaDeSituacao($situacaoAntes, $situacaoDepois)) {
    if ($situacaoAntes->getNome() !== 'Em Aberto' && $situacaoDepois->getNome() !== 'Transferido') {
      if ($tecnicoCh && ($tecnicoCh->getLogin() !== $tecnico->getLogin())) {
        echo json_encode(array(
          "error" => 409,
          "mensagem" => "Técnico não é autorizado a modificar esta situação",
        ));
        return false;
      }
      $situacaoAntesNome = $situacaoAntes->getNome();
      $situacaoDepoisNome = $situacaoDepois->getNome();
      if (empty($data->descricao)) {
        if ($situacaoAntesNome === 'Transferido') {
          $alteracao->setDescricao('Em atendimento por ' . $tecnico->getNome());
        } else if ($situacaoAntesNome === 'Em Atendimento') {
          if ($situacaoDepoisNome === 'Pendente') {
            $alteracao->setDescricao('Chamado pendente por falta de recursos');
          } else if ($situacaoDepoisNome === 'Concluido') {
            $alteracao->setDescricao('Chamado concluído');
          }
        } else {
          $alteracao->setDescricao('Recursos chegaram');
        }
      }
      try {
        $tecnico->cadastraAlteracao($alteracao);
        $chamado->setTecnico($tecnico);
        $chamado->update();
      } catch (\Exception $e) {
        echo json_encode(array(
          "error" => 500,
          "mensagem" => $e->getMessage()
        ));
      }
      // if ($situacaoAntesNome === 'Transferido') {
      //   if (empty($data->descricao)) {
      //     $alteracao->setDescricao("Em atendimento por " . $tecnico->getNome());
      //   }
      //   try {
      //     $tecnico->cadastraAlteracao($alteracao);
      //     $chamado->setTecnico($tecnico);
      //     $chamado->update();
      //   } catch (\Exception $e) {
      //     echo json_encode(array(
      //       "error" => 500,
      //       "mensagem" => $e->getMessage()
      //     ));
      //   }
      // } else if($situacaoAntesNome === 'Em Atendimento') {
      //   if($situacaoDepoisNome === 'Pendente') {
      //     if(empty($data->descricao)) {
      //       $alteracao->setDescricao("Chamado pendente por falta de recursos");
      //     }
      //   } else {

      //   }

      // if ($tecnico->mudaSituacao($chamado, $situacaoDepois)) { }
    } else {
      // var_dump($tecnico);
      if (empty($data->novo_setor) && empty($data->novo_tecnico)) {
        echo json_encode(array(
          "error" => 400,
          "mensagem" => "Novas informações devem ser fornecidas (novo setor ou novo técnico)."
        ));
        // return false;
      } else if (!empty($data->novo_setor)) {
        $novoSetor = new Setor();
        $novoSetor->setNome($data->novo_setor);
        if ($setor && $novoSetor->getNome() === $setor->getNome()) {
          echo json_encode(array(
            "error" => 400,
            "mensagem" => "Transferência para o mesmo Setor não é permitida",
          ));
          return false;
        }
        if (empty($data->descricao)) {
          $alteracao->setDescricao("Do setor " . $setor->getNome() . " para " . $novoSetor->getNome());
        }
        // var_dump($alteracao);
        if ($novoSetor->read(false)) {
          // var_dump($novoSetor);
          try {
            $tecnico->cadastraAlteracao($alteracao);
            $chamado->setSetor($novoSetor);
            $chamado->setTecnico(null);
            $chamado->update();
          } catch (\Exception $e) {
            echo json_encode(array(
              "error" => 500,
              "mensagem" => $e->getMessage()
            ));
          }
        } else {
          echo json_encode(array(
            "error" => 404,
            "mensagem" => "Setor não encontrado",
          ));
        }
      } else {
        $novoTecnico = new Tecnico();
        $novoTecnico->setLogin($data->novo_tecnico);
        // var_dump($alteracao);
        if (
          $tecnico->getLogin() === $novoTecnico->getLogin() &&
          $situacaoDepois->getNome() === 'Transferido'
        ) {
          echo json_encode(array(
            "error" => 409,
            "mensagem" => "Técnico tem que ser diferente",
          ));
          return false;
        }
        if ($tecnico->getLogin() === $novoTecnico->getLogin() || $novoTecnico->read()) {
          if ($situacaoDepois->getNome() === 'Transferido' && empty($data->descricao)) {
            $alteracao->setDescricao("Do técnico " . $tecnico->getNome() . " para " . $novoTecnico->getNome());
          }
          try {
            $tecnico->cadastraAlteracao($alteracao);
            $chamado->setTecnico($novoTecnico);
            $chamado->update();
          } catch (\Exception $e) {
            echo json_encode(array(
              "error" => 500,
              "mensagem" => $e->getMessage()
            ));
          }
        } else {
          echo json_encode(array(
            "error" => 404,
            "mensagem" => "Técnico não encontrado",
          ));
        }
      }
    }
  } else {
    echo json_encode(array(
      "error" => 409,
      "mensagem" => "Siga o fluxo de estados",
    ));
    return;
  }
} else {
  echo json_encode(array(
    "error" => 404,
    "mensagem" => "Chamado não encontrado",
  ));
  return;
}

echo json_encode(array(
  "mensagem" => "Sucesso",
));
