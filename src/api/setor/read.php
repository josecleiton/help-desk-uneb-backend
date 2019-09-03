
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__).  '/../../model/setor.php');

// autenticação aqui

$setor= new Setor();
echo json_encode(array_map(function($setor){
  return $setor->getJSON();
}, $setor->readAll()));

?>