
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__).  '/../../model/chamado.php');
require_once(dirname(__FILE__).  '/../../model/chamado_ti.php');
require_once(dirname(__FILE__).  '/../../model/usuario.php');
require_once(dirname(__FILE__).  '/../../model/setor.php');

$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
if(empty($data->cpf) || empty($data->nome) || empty($data->email) || empty($data->telefone) ||
   empty($data->setor_nome) || empty($data->descricao)) {
  echo json_encode(array(
    "error" => 404,
    "mensagem" => "Deve-se fornecer cpf, nome, email, telefone do usuário.
      Além do setor e a descrição do chamado."
  ));
  return false;
}
$usuario = new Usuario();
$usuario->setCPF($data->cpf);
$usuario->setEmail($data->email);
$usuario->setNome($data->nome);
$usuario->setTelefone($data->telefone);
if(!$usuario->existe()) {
  if(!$usuario->create()) {
    echo json_encode(array(
      "error" => 409,
      "mensagem" => "Usuário não pode ser criado."
    ));
    return false;
  }
}

http_response_code(201);
$setor = new Setor();
$setor->setNome($data->setor_nome);
if($setor_nome !== "TI") {
  $chamado = new Chamado();
  $chamado->setDescricao($data->descricao);
  $chamado->setUsuario($usuario);
  $chamado->setSetor($setor->read());
  $chamado->create();
}

// se usuário não existir: crie
// atribua esse usuário ao chamado
// persista-o no banco com o ChamadoDAO

?>