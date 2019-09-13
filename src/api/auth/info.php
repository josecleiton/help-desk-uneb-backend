
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__file__) . "/../../model/tecnico.php");
require_once(dirname(__file__) . "/../../model/request.php");

if (!($jwtToken = Request::getAuthToken())) {
  echo json_encode(array("error" => 400, "mensagem" => "Token não foi submetido"));
  return false;
}
if ($decoded = Tecnico::readJWT($jwtToken)) {
  // $decoded["senha"] = null;
  $decoded->senha = null;
  echo json_encode($decoded);
} else {
  echo json_encode(array("req" => $jwtToken, "error" => 409, "mensagem" => "Erro na leitura do jwt"));
}
// $data = json_decode(file_get_contents("php://input"));

// if(empty($data->token)) {
//   echo json_encode(["error" => 400, "mensagem" => "Um token JWT deve ser submetido"]);
//   return false;
// }

// $decoded = Tecnico::readJWT($data->token);
// echo json_encode($decoded);
// if($decoded) {
//   $decoded["senha"] = null;
//   echo json_encode($decoded);
// } else {
//   echo json_encode(array("error" => 409, "mensagem" => "Erro na leitura do jwt"));
// }

?>