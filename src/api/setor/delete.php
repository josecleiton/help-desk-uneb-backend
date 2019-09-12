
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__).  '/../../model/admin.php');
require_once(dirname(__FILE__).  '/../../model/setor.php');
require_once(dirname(__FILE__).  '/../../model/request.php');

$admin = new Admin();
if(!Admin::readJWTAndSet(Request::getAuthToken(), $admin)) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Você não está autenticado"
  ));
  return false;
}

$data = json_decode(file_get_contents("php://input"));

if(empty($data->nome)) {
  // http_response_code(503);
  echo json_encode(array(
    "error" => 409,
    "mensagem" => "Poucos argumentos passados.",
  ));
} else {
  $setor = new Setor();
  $setor->setNome($data->nome);
  if($admin->deleteSetor($setor)) {
    echo json_encode(array(
      "mensagem" => "Sucesso.",
    ));
  } else {
    // http_response_code(500);
    echo json_encode(array(
      "error" => 400,
      "mensagem" => "Nenhum registro modificado."
    ));
  }

}


// autenticação aqui

?>