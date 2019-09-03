<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// require_once(dirname(__FILE__) . '/../../util/post_isset.php');
require_once(dirname(__FILE__).  '/../../model/setor.php');

$data = json_decode(file_get_contents("php://input"));
// var_dump($data->nome);
// var_dump($data->telefone);
// var_dump($data->email);

if(empty($data->nome) || empty($data->telefone) || empty($data->email)){
  http_response_code(400);
  echo json_encode(array(
    "mensagem" => "Deve-se enviar nome, telefone, email do setor."
  ));
  return false;
}

// echo json_encode(array(
//   "mensagem" => "Ate aqui deu bom",
// ));

$setor = new Setor();
// var_dump($_POST["nome"]);
$setor->setNome($data->nome);
$setor->setTelefone($data->telefone);
$setor->setEmail($data->email);
// echo json_encode($setor->getJSON());
// return;
if($setor->create()) {
  echo json_encode($setor->getJSON());
} else {
  http_response_code(409);
  echo json_encode(array(
    "mensagem" => "Erro ao criar o setor.",
  ));
}

?>