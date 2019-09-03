
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__).  '/../../model/setor.php');

$data = json_decode(file_get_contents("php://input"));

if(empty($data->nome)) {
  http_response_code(503);
  echo json_encode(array(
    "mensagem" => "Poucos argumentos passados.",
  ));
} else {
  $setor = new Setor();
  $setor->setNome($data->nome);
  if($setor->delete()) {
    echo json_encode(array(
      "mensagem" => "Sucesso.",
    ));
  } else {
    http_response_code(500);
    echo json_encode(array(
      "mensagem" => "Nenhum registro modificado."
    ));
  }

}


// autenticação aqui

?>