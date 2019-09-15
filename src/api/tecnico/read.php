
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once dirname(__FILE__) . '/../../model/gerente_setor.php';
require_once dirname(__FILE__) . '/../../model/request.php';

if (!Tecnico::readJWTAndSet(Request::getAuthToken(), $tecnico = new Tecnico())) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Você não está autenticado",
  ));
  return false;
}
// var_dump($tecnico);

$data = json_decode(file_get_contents("php://input"));
if (!empty($data->setor)) {

  $setor = new Setor();
  $setor->setNome($data->setor);
  if ($setor->read(false)) {
    $tecnico->setSetor($setor);
  } else {
    echo json_encode(array(
      "error" => 404,
      "mensagem" => "Setor não encontrado",
    ));
    return false;
  }
} else if (!empty($data->privilegiados)) {

  $tecnico->getSetor()->setID(null);
  $payload = array();
  // var_dump($tecnico);
  // var_dump($tecnico->readAllBySetor());
  foreach ($tecnico->readAllBySetor() as $tec) {
    if ($tec->getCargo())
      array_push($payload, $tec->getJSON(array("chamados" => true)));
  }
  //   var_dump($tec->cargo);
  // }
  echo json_encode($payload);

  return;
}
echo json_encode(array_map(function ($ntecnico) {
  return $ntecnico->getJSON(array("chamados" => true));
  // var_dump($tecnico);
}, $tecnico->readAllBySetor()));

?>