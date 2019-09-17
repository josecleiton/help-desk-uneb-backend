
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once dirname(__FILE__) . '/../../model/gerente_setor.php';
require_once dirname(__FILE__) . '/../../model/admin.php';
require_once dirname(__FILE__) . '/../../model/request.php';

// var_dump(Admin::readJWT(Request::getAuthToken()));
// var_dump(Request::getAuthToken());
if (!Admin::readJWTAndSet(Request::getAuthToken(), $admin = new Admin())) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Você não está autenticado",
  ));
  return false;
}

$data = json_decode(file_get_contents("php://input"));

if (
  empty($data->nome) || empty($data->email) || empty($data->telefone)
  || empty($data->login) || empty($data->setor)
) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Requerido: nome, email, telefone, senha e setor do Gerente.",
  ));
  return false;
}

$setor = new Setor();
$setor->setNome($data->setor);
if ($setor->read()) {
  $gerente = new GerenteSetor();
  $gerente->setLogin($data->login);
  $gerente->setNome($data->nome);
  $gerente->setEmail($data->email);
  $gerente->setTelefone($data->telefone);
  if (!empty($data->senha)) {
    $gerente->setSenha($data->senha);
  } else {
    $gerente->setSenha("senhafraca");
  }
  $gerente->setSetor($setor);
  if ($admin->createGerente($gerente)) {
    echo json_encode($gerente->getJSON());
  } else {
    echo json_encode(array(
      "error" => 409,
      "mensagem" => "Erro na criação de Gerente.",
    ));
  }
} else {
  echo json_encode(array(
    "error" => 404,
    "mensagem" => "Setor inválido.",
  ));
}

?>
