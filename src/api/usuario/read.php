<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST");
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

$EMAIL = $_POST["email"];
$CPF = $_POST["cpf"];
// $CPF = "12345678901";
// $EMAIL = "bla@bla.com";
$usuario = new Usuario();
if($CPF) {
   if(!isCPF($CPF)) {
      http_response_code(401);
      echo json_encode(array(
         "mensagem" => "CPF inválido."
      ));
      return null;
   }
   $usuario->setCPF($CPF);
} else if($EMAIL) {
   if(!filter_var($EMAIL, FILTER_VALIDATE_EMAIL)) {
      http_response_code(401);
      echo json_encode(array(
         "mensagem" => "Email inválido."
      ));
      return null;
   }
   $usuario->setEmail($EMAIL);

} else {
   http_response_code(400);
   echo json_encode(array(
      "mensagem" => "Necessita-se de CPF ou Email."
   ));
   return null;
}

if($status = $usuario->read()[1]) {
   $usuarioJSON = $usuario->getJSON();
   $usuarioJSON["mensagem"] = "Sucesso";
   echo json_encode($usuarioJSON);
} else {
   http_response_code(404);
   echo json_encode(array(
      "mensagem" => "Usuário não encontrado."
   ));
}

?>
