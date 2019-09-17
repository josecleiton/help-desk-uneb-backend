
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once dirname(__FILE__) . '/../../model/problema.php';
require_once dirname(__FILE__) . '/../../model/setor.php';
require_once dirname(__FILE__) . '/../../model/gerente_setor.php';
require_once dirname(__FILE__) . '/../../model/request.php';


// var_dump(Admin::readJWT(Request::getAuthToken()));
// var_dump(Request::getAuthToken());
$data = json_decode(file_get_contents("php://input"));
if (empty($data->id)) {
  echo json_encode(array(
    "error" => 400,
    "mensagem" => "Falta id do problema",
  ));
  return false;
}

if (GerenteSetor::readJWTAndSet(Request::getAuthToken(), $gerente = new GerenteSetor())) {
  $problema = new Problema();
  $problema->setID($data->id);
  if (!empty($data->setor) && !$gerente->getSetor()->getID()) {
    $setor = new Setor();
    $setor->setID($data->setor);
    if (!$setor->read(false)) {
      echo json_encode(array(
        "error" => 400,
        "mensagem" => "Setor não encontrado",
      ));
      return false;
    }
    $gerente->setSetor($setor);
  }
  if ($problema->read()) {
    // var_dump($problema->getSetor()->getID());
    // var_dump($gerente->getSetor()->getID());
    // var_dump($gerente);
    if ($gerente->getSetor()->getID() !== $problema->getSetor()->getID()) {
      echo json_encode(array(
        "error" => 400,
        "mensagem" => "Setor inválido",
      ));
      return false;
    }
    if (!$gerente->deleteProblema($problema)) {
      echo json_encode(array(
        "error" => 500,
        "mensagem" => "Erro na remoção do problema"
      ));
      return false;
    }
  } else {
    echo json_encode(array(
      "error" => 404,
      "mensagem" => "Problema não encontrado",
    ));
    return false;
  }
}

echo json_encode(array(
  mensagem => "Sucesso na remoção do problema",
))

?>