
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once dirname(__FILE__) . '/../../model/gerente_setor.php';
require_once dirname(__FILE__) . '/../../model/request.php';

if (!GerenteSetor::readJWTAndSet(Request::getAuthToken(), $gerente = new GerenteSetor())) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Você não está autenticado",
  ));
  return false;
}

$data = json_decode(file_get_contents("php://input"));

if (empty($data->login)) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Login não fornecido",
  ));
  return false;
}

$tecnico = new Tecnico();
$tecnico->setLogin($data->login);
$tecnico->read();
if ($tecnico->getNome()) {
  try {
    $gerente->deleteTecnico($tecnico);
    echo json_encode(array(
      "mensagem" => "Sucesso na remoção do Técnico " . $tecnico->getNome(),
    ));
  } catch (\Exception $e) {
    echo json_encode(array(
      "error" => 500,
      "mensagem" => $e->getMessage(),
    ));
  }
} else {
  echo json_encode(array(
    "error" => 404,
    "mensagem" => "Técnico não encontrado",
  ));
}
