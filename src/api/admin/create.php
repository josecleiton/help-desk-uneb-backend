
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__).  '/../../model/admin.php');
require_once(dirname(__FILE__).  '/../../model/setor.php');
require_once(dirname(__FILE__) . '/../../model/request.php');

$admin = new Admin();
if (!Admin::readJWTAndSet(Request::getAuthToken(), $admin)) {
    echo json_encode(array(
        "error" => 400,
        "mensagem" => "Você não está autenticado",
    ));
    return false;
}


$data = json_decode(file_get_contents("php://input"));

if(empty($data->nome) || empty($data->email) || empty($data->telefone)
   || empty($data->login) || empty($data->senha)) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Requerido: nome, email, telefone, login e senha do Admin.",
  ));
  return false;
}

$novoAdmin = new Admin();
$novoAdmin->setLogin($data->login);
$novoAdmin->setNome($data->nome);
$novoAdmin->setEmail($data->email);
$novoAdmin->setTelefone($data->telefone);
$novoAdmin->setSenha($data->senha);
// $novoAdmin->setSetor($setor);

if($admin->createAdmin($novoAdmin)) {
  echo json_encode($novoAdmin->getJSON(array("chamados" => true, "setor" => true)));
} else {
  echo json_encode(array(
    "error" => 409,
    "mensagem" => "Erro na criação de Admin.",
  ));
}



?>