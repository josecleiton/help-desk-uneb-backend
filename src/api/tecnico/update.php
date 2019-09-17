

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

if (empty($data->email) && empty($data->telefone) && empty($data->nome)) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Dados para atualização não foram fornecidos"
  ));
  return false;
}

$tecnico = new Tecnico();
$tecnico->setLogin($data->login);
$tecnico->read(array("setor" => true));
if ($tecnico->getNome()) {
  if ($data->email) {
    $tecnico->setEmail($data->email);
  }
  if ($data->telefone) {
    $tecnico->setTelefone($data->telefone);
  }
  if ($data->nome) {
    $tecnico->setNome($data->nome);
  }
  if ($data->setor) {
    if ($tecnico->getCargo() === 'A') {
      echo json_encode(array(
        "error" => 409,
        "mensagem" => "Técnico não tem setor",
      ));
      return false;
    }
    $setor = new Setor();
    $setor->setNome($data->setor);
    if (!$setor->read(false)) {
      echo json_encode(array(
        "error" => 404,
        "mensagem" => "Setor inválido",
      ));
      return false;
    }
    $tecnico->setSetor($setor);
  }
  try {
    $gerente->updateTecnico($tecnico);
    echo json_encode(array(
      "mensagem" => "Sucesso na atualização do Técnico " . $tecnico->getNome(),
    ));
  } catch (\Exception $e) {
    echo json_encode(array(
      "error" => 400,
      "mensagem" => $e->getMessage(),
    ));
  }
} else {
  echo json_encode(array(
    "error" => 404,
    "mensagem" => "Técnico não encontrado",
  ));
}
