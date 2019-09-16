
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__) .  '/../../model/setor.php');
require_once(dirname(__FILE__) . '/../../model/admin.php');
require_once(dirname(__FILE__) . '/../../model/request.php');

// var_dump(Admin::readJWT(Request::getAuthToken()));
// var_dump(Request::getAuthToken());
$admin = new Admin();
if (!Admin::readJWTAndSet(Request::getAuthToken(), $admin)) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Você não está autenticado"
  ));
  return false;
}

$data = json_decode(file_get_contents("php://input"));

if (empty($data->cod) || empty($data->nome_antigo)) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Código do setor não enviado",
  ));
  return false;
}

$setor = new Setor();
$setor->setID($data->cod);
if ($setor->read(false) && ($setor->getNome() === $data->nome_antigo)) {
  if (!empty($data->nome)) {
    $setor->setNome($data->nome);
  }
  if (!empty($data->email)) {
    $setor->setEmail($data->email);
  }
  if (!empty($data->telefone)) {
    $setor->setTelefone($data->telefone);
  }
  try {
    if (!$setor->update())
      throw new Exception("Algum erro ocorreu na atualização dos dados");
    echo json_encode(array(
      "mensagem" => "Sucesso no armazenamento dos novos dados",
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
    "mensagem" => "Setor inválido",
  ));
}


?>
