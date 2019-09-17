<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once dirname(__FILE__) . '/../../model/problema.php';
require_once dirname(__FILE__) . '/../../model/setor.php';
require_once dirname(__FILE__) . '/../../model/gerente_setor.php';
require_once dirname(__FILE__) . '/../../model/request.php';


// var_dump(Admin::readJWT(Request::getAuthToken()));
// var_dump(Request::getAuthToken());
$data = json_decode(file_get_contents("php://input"));

if (GerenteSetor::readJWTAndSet(Request::getAuthToken(), $gerente = new GerenteSetor())) {
  if (($setor = $gerente->getSetor()) && $setor->getID()) {
    if ($setor->read()) {
      // var_dump($setor);
      // var_dump($setor->getProblemas());
      echo json_encode(array_map(function ($problema) {
        // var_dump($problema);
        return $problema->getJSON();
      }, $setor->getProblemas()));
    } else {
      echo json_encode(array(
        "error" => 404,
        "mensagem" => "Setor inválido",
      ));
    }

    return;
  }
}

if (empty($data->setor)) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Deve-se informar o setor",
  ));
  return false;
}

$setor = new Setor();
$setor->setNome($data->setor);
if ($setor->read()) {
  $problema = new Problema();
  $problema->setSetor($setor);
  echo json_encode(array_map(function ($problema) {
    return $problema->getJSON();
  }, $problema->readAllBySetor()));
} else {
  echo json_encode(array(
    "error" => 404,
    "mensagem" => "Setor não encontrado",
  ));
}
