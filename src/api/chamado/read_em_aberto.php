<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__).  '/../../model/chamado.php');

// $data = json_decode(file_get_contents("php://input"));

// AUTENTICA

$chamado = new Chamado();
// var_dump($chamado->readEmAberto());
// $chamados = $chamado->readEmAberto();
// $chamados_copy = array_map(function($chamado){
//   return $chamado;
// }, $chamados)

// var_dump($chamados);
echo json_encode(array_map(function($chamado){
  return $chamado->getJSON();
}, $chamado->readEmAberto()));
// echo json_encode(array_map(function($chamado){
//   return $chamado->getJSON();
// }, $chamado->readEmAberto()));

?>