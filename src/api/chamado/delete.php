
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__).  '/../../model/chamado.php');

$data = json_decode(file_get_contents("php://input"));

if(empty($data->id)) {
  // http_response_code(400);
  return;
}

$chamado = new Chamado($data->id);
if($chamado->delete()) {
  // http_response_code(200);
  echo json_encode(array(
    "mensagem" => "Chamado excluído",
  ));
} else {
  // http_response_code(404);
  echo json_encode(array(
    "mensagem" => "Chamado está em atendimento",
    "error" => "Acesso proibido",
  ));
}


?>
