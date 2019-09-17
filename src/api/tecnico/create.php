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

if (
  empty($data->nome) || (empty($data->email) || !filter_var($data->email, FILTER_VALIDATE_EMAIL)) || empty($data->telefone)
  || empty($data->login) || empty($data->setor)
) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Requerido: nome, email, telefone, senha e setor do Técnico.",
  ));
  return false;
}

// if (strlen($data->senha) <= 6) {
//   echo json_encode(array(
//     "error" => 400,
//     "mensagem" => "Senha muito curta",
//   ));
//   return false;
// }

$setor = new Setor();
$setor->setNome($data->setor);
if ($setor->read(false)) {
  $tecnico = new  Tecnico();
  $tecnico->setLogin($data->login);
  $tecnico->setNome($data->nome);
  $tecnico->setEmail($data->email);
  $tecnico->setTelefone($data->telefone);
  if (!empty($data->senha)) {
    $tecnico->setSenha($data->senha);
  } else {
    $tecnico->setSenha("senhafraca");
  }
  $tecnico->setSetor($setor);
  try {
    $gerente->createTecnico($tecnico);
    echo json_encode($tecnico->getJSON());
  } catch (\Exception $e) {
    echo json_encode(array(
      "error" => 409,
      "mensagem" => $e->getMessage(),
    ));
  }
} else {
  echo json_encode(array(
    "error" => 409,
    "mensagem" => "Setor inválido.",
  ));
}
