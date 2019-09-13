
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

$data = json_decode(file_get_contents("php://input"));
if (!empty($data->id)) {
  $chamado = new Chamado($data->id);
  if ($chamado->read(array("tecnico" => true, "usuario" => true))) {
    echo json_encode($chamado->getJSON());
  } else {
    echo json_encode(array(
      "error" => 404,
      "mensagem" => "Chamado não encontrado.",
    ));
  }
} else if (!empty($data->tecnico)) {


  // var_dump(Request::getAuthToken());
  // return;
  if (!Tecnico::readJWTAndSet(Request::getAuthToken(), $tecnico = new Tecnico())) {
    echo json_encode(array(
      "error" => 400,
      "mensagem" => "Token deve ser enviado.",
    ));
    return false;
  }
  // var_dump($tecnico);
  // echo json_encode($tecnico->getChamadosJSON(array("tecnico" => true)));
  // return;
  if (empty($data->situacao)) {
    echo json_encode($tecnico->getChamadosJSON(array("tecnico" => true)));
  } else {
    $situacao = new Situacao();
    $situacao->setNome($data->situacao);
    if ($situacao->read()) {
      // var_dump($situacao);
      // return;
      if (empty($data->setor)) {
        echo json_encode(array_map(function ($chamado) {
          return $chamado->getJSON(array("tecnico" => true));
        }, $tecnico->getChamadosBySituacao($situacao)));
      } else {
        echo json_encode(array_map(function ($chamado) {
          return $chamado->getJSON(array("tecnico" => true));
        }, $tecnico->getChamadosSetorBySituacao($situacao)));
      }
    } else {
      echo json_encode(array(
        "error" => 404,
        "mensagem" => "Situação não encontrada."
      ));
    }
  }
} else {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Forneça as informações necessárias.",
  ));
  return false;
}

?>