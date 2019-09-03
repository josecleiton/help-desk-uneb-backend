
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__).  '/../../model/chamado.php');
require_once(dirname(__FILE__).  '/../../model/usuario.php');

$data = json_encode(file_get_contents("php://input"));
if(empty($data->nome) || empty($data->email) || empty($data->telefone) ||
   empty($data->cpf) || empty($data->setor) || empty($data->descricao)) {
  http_response_code(400);
  echo json_encode(array(
    "mensagem" => "Deve-se fornecer cpf, nome, email, telefone do usuário.
      Além do setor e a descrição do chamado."
  ));
  return false;
}
$usuario = new Usuario();
$usuario->setEmail($data->email);
if($usuario->read()) {
  $chamado = new Chamado();
} else {
  $usuario->setNome($data->nome);
  $usuario->setCPF($data->cpf);
  $usuario->setTelefone($data->telefone);
}

// se usuário não existir: crie
// atribua esse usuário ao chamado
// persista-o no banco com o ChamadoDAO

?>