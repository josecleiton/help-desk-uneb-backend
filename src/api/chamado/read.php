
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__).  '/../../model/chamado.php');

$data = json_decode(file_get_contents("php://input"));
if(!empty($data->id)) {
  $chamado = new Chamado($data->id);
  if($chamado->read(array("tecnico" => true, "usuario" => true))) {
    echo json_encode($chamado->getJSON());
  } else {
    echo json_encode(array(
      "error" => 404,
      "mensagem" => "Chamado não encontrado.",
    ));
  }

} else {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "ID tem que ser preenchido",
  ));
}

?>