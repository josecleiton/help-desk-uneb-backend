<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__).  '/../../model/tecnico.php');
require_once(dirname(__FILE__).  '/../../model/setor.php');

$data = json_decode(file_get_contents("php://input"));

if(empty($data->nome) || empty($data->email) || empty($data->telefone)
   || empty($data->login) || empty($data->setor) || empty($data->senha)) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Requerido: nome, email, telefone, senha e setor do Técnico.",
  ));
  return false;
}

$setor = new Setor();
$setor->setNome($data->setor);
if($setor->read()) {
  $tecnico = new  Tecnico();
  $tecnico->setLogin($data->login);
  $tecnico->setNome($data->nome);
  $tecnico->setEmail($data->email);
  $tecnico->setTelefone($data->telefone);
  $tecnico->setSenha($data->senha);
  $tecnico->setSetor($setor);
  if($tecnico->create()) {
    echo json_encode($tecnico->getJSON());
  } else {
    echo json_encode(array(
      "error" => 409,
      "mensagem" => "Erro na criação de Técnico.",
    ));
  }
} else {
  echo json_encode(array(
    "error" => 409,
    "mensagem" => "Setor inválido.",
  ));
}



?>