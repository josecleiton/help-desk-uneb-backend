<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__).  '/../../model/chamado.php');
require_once(dirname(__FILE__).  '/../../model/tecnico.php');
require_once(dirname(__FILE__).  '/../../model/setor.php');
require_once(dirname(__FILE__) . '/../../model/request.php');

$tecnico = new Tecnico();
if (!Tecnico::readJWTAndSet(Request::getAuthToken(), $tecnico)) {
    echo json_encode(array(
        "error" => 400,
        "mensagem" => "Você não está autenticado",
    ));
    return false;
}

$chamado = new Chamado();
$setor = $tecnico->getSetor();
// var_dump($tecnico);
// var_dump($setor);
// return;
// var_dump ($chamado->readEmAberto($setor));
// return;
  echo json_encode(array_map(function($chamado){
    return $chamado->getJSON();
  }, $chamado->readEmAberto($setor)));

?>