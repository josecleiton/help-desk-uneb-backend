<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once(dirname(__file__) . "/../../model/usuario.php");
/* require_once("../../config/database.php"); */
/* require_once("../../model/usuario.php"); */

/* echo json_encode($_POST); */
/* return; */

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

$CPF = $_POST["cpf"];
if(!isCPF($CPF)) {
   http_response_code(400);
   /* echo json_encode( */
   /*    array("error" => 400) */
   /* ); */
   return null;
}

$usuario = new Usuario($CPF);
if(($status = $usuario->read())) {
   http_response_code(200);
   echo $usuario->getJSON();
} else {
   http_response_code(404);
   echo json_encode(array());
}

?>
