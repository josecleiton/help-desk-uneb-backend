
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__) .  '/../../model/setor.php');
require_once dirname(__FILE__) . '/../../model/gerente_setor.php';
require_once dirname(__FILE__) . '/../../model/request.php';

$data = json_decode(file_get_contents("php://input"));

if (
  GerenteSetor::readJWTAndSet(Request::getAuthToken(), $gerente = new GerenteSetor())
  && $gerente->getSetor()->getID()
) {
  $setor = $gerente->getSetor();
  if ($setor->read()) {
    echo json_encode($setor->getJSON());
  } else {
    echo json_encode(array(
      "error" => 404,
      "mensagem" => "Setor não encontrado"
    ));
  }
  return false;
}

$setor = new Setor();
if (empty($data->nome)) {
  echo json_encode(array_map(function ($setor) {
    return $setor->getJSON();
  }, $setor->readAll()));
} else {
  $setor->setNome($data->nome);
  if ($setor->read()) {
    echo json_encode($setor->getJSON());
  } else {
    echo json_encode(array(
      "error" => 404,
      "mensagem" => "Erro na busca por setor $data->nome."
    ));
  }
}

?>