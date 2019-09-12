
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once dirname(__FILE__) . '/../../model/request.php';
require_once dirname(__FILE__) . '/../../model/gerente_setor.php';
require_once dirname(__FILE__) . '/../../model/admin.php';
require_once dirname(__FILE__) . '/../../model/problema.php';

// var_dump(Admin::readJWT(Request::getAuthToken()));
// var_dump(Request::getAuthToken());
$data = json_decode(file_get_contents("php://input"));
$tecnicoPrivilegiado = null;
$setor = null;

// var_dump($data);
// return;

// return;
if (!empty($data->setor)) {
  if (!Admin::readJWTAndSet(Request::getAuthToken(), $tecnicoPrivilegiado = new Admin())) {
    echo json_encode(array(
      "error" => 400,
      "mensagem" => "Você não está autenticado",
    ));
    return false;
  }
  $setor = new Setor();
  $setor->setID($data->setor);
  if (!$setor->read()) {
    echo json_encode(array(
      "error" => 404,
      "mensagem" => "Setor não existe."
    ));
    return false;
  }
} else {
  if (!GerenteSetor::readJWTAndSet(Request::getAuthToken(), $tecnicoPrivilegiado = new GerenteSetor())) {
    echo json_encode(array(
      "error" => 400,
      "mensagem" => "Você não está autenticado",
    ));
    return false;
  }
  $setor = $tecnicoPrivilegiado->getSetor();
}

if (empty($data->descricao)) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "É necessário descrição do setor."
  ));
  return false;
}

$problema = new Problema();
$problema->setDescricao($data->descricao);
$problema->setSetor($setor);
// var_dump($problema);
// return;
if ($problema->create()) {
  echo json_encode($problema->getJSON());
} else {
  echo json_encode(array(
    "error" => 409,
    "mensagem" => "Problema na criação de problema"
  ));
}

?>