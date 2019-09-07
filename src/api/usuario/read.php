<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Methods: *");
// header("Access-Control-Allow-Credentials: true");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Origin, X-Auth-Token");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Access-Control-Expose-Headers: X-Pagination-Current-Page");
require_once(dirname(__file__) . "/../../model/usuario.php");

function sumDigit($str, $start_mul, $end) {
   $soma = 0;
   for($i = 0; $i < $end; $i++, $start_mul--) {
     $soma += $str[$i]*$start_mul;
   }
   return $soma;
}

function isCPF($cpf) {
   if(ctype_digit($cpf) && strlen($cpf) == 11) {
      // verificar se cpf é valido
      return true;
   }
   return false;
}

$data = json_decode(file_get_contents("php://input"));
$usuario = new Usuario();
if(!empty($data->cpf)) {
   if(!isCPF($data->cpf)) {
      // http_response_code(401);
      echo json_encode(array(
         "error" => 401,
         "mensagem" => "CPF inválido."
      ));
      return false;
   }
   $usuario->setCPF($data->cpf);
} else if(!empty($data->email)) {
   if(!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
      // http_response_code(401);
      echo json_encode(array(
         "error" => 401,
         "mensagem" => "Email inválido."
      ));
      return false;
   }
   $usuario->setEmail($data->email);

} else {
   // http_response_code(400);
   echo json_encode(array(
      "error" => 400,
      "mensagem" => "Necessita-se de CPF ou Email."
   ));
   return false;
}

if($usuario->read(array("chamados" => true))) {
   http_response_code(200);
   $usuarioJSON = $usuario->getJSON();
   $usuarioJSON["mensagem"] = "Sucesso";
   echo json_encode($usuarioJSON);
} else {
   echo json_encode(array(
      "error" => 404,
      "mensagem" => "Usuário não encontrado."
   ));
}

?>
