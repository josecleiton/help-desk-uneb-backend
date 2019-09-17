
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(dirname(__FILE__) .  '/../../model/chamado.php');
require_once(dirname(__FILE__) .  '/../../model/chamado_ti.php');
require_once(dirname(__FILE__) .  '/../../model/usuario.php');
require_once(dirname(__FILE__) .  '/../../model/setor.php');
require_once(dirname(__FILE__) . '/../../model/problema.php');
require_once(dirname(__FILE__) . '/../../model/upload.php');

// var_dump($data);
// echo json_encode(array(
//   "file" => $_POST["arquivo
// ));
if (
  empty($_POST["cpf"]) || empty($_POST["nome"]) || empty($_POST["email"]) || empty($_POST["telefone"]) || empty($_POST["descricao"])
) {
  echo json_encode(array(
    "error" => 404,
    "mensagem" => "Deve-se fornecer cpf, nome, email, telefone do usuário.
      Além do setor e a descrição do chamado."
  ));
  return false;
}
if ($_FILES["arquivo"]) {
  try {
    $uploader = new Upload($_FILES["arquivo"]);
  } catch (\Exception $e) {
    echo json_encode(array(
      "error" => 400,
      "mensagem" => $e->getMessage(),
    ));
    return false;
  }
}
$usuario = new Usuario();
$usuario->setCPF($_POST["cpf"]);
$usuario->setEmail($_POST["email"]);
$usuario->setNome($_POST["nome"]);
$usuario->setTelefone($_POST["telefone"]);
if (!$usuario->existe()) {
  if (!$usuario->create()) {
    echo json_encode(array(
      "error" => 409,
      "mensagem" => "CPF ou email já cadastrado",
      // "data" => $_POST,
    ));
    return false;
  }
}

$setor = new Setor();
$setor->setNome($_POST["setor_nome"]);
if ($setor->read()) {
  if ($_POST["setor_nome"] !== "TI" || empty($_POST["ti"])) {
    $chamado = new Chamado();
  } else {
    if (
      empty($_POST["software"]) || empty($_POST["plugins"]) || empty($_POST["sala"])
      || empty($_POST["data_utilizacao"]) || empty($_POST["link"])
    ) {
      echo json_encode(array(
        "error" => 400,
        "mensagem" => "Campos do módulo de instalação não fornecidos."
      ));
      return false;
    }
    $chamado = new ChamadoTI();
    $chamado->setSoftware($_POST["software"]);
    $chamado->setPlugins($_POST["plugins"]);
    $chamado->setSala($_POST["sala"]);
    $chamado->setDataUtilizacao($_POST["data_utilizacao"]);
    $chamado->setLink($_POST["link"]);
  }
  if (!empty($_POST["problema"])) {
    $problema = new Problema();
    $problema->setSetor($setor);
    $problema->setDescricao($_POST["problema"]);
    if ($problema->read()) {
      $chamado->setProblema($problema);
    } else {
      echo json_encode(array(
        "error" => 404,
        "mensagem" => "Problema não encontrado"
      ));
      return false;
    }
  }
  if ($uploader) {
    try {
      $chamado->setArquivo($uploader->getCaminho());
    } catch (\Exception $e) {
      echo json_encode(array(
        "error" => 500,
        "mensagem" => $e->getMessage(),
      ));
      return false;
    }
  }
  $chamado->setDescricao($_POST["descricao"]);
  $chamado->setUsuario($usuario);
  $chamado->setSetor($setor);
  if ($k = $chamado->create()) {
    http_response_code(201);
    echo json_encode($chamado->getJSON(array(
      "tecnico" => true
    )));
  } else {
    echo json_encode(array(
      "error" => 409,
      "mensagem" => "Algum erro aconteceu ao criar o chamado.",
      "o" => $k
    ));
  }
  // } else {

  // }
} else {
  echo json_encode(array(
    "error" => 404,
    "mensagem" => "Setor não encontrado",
  ));
}

// se usuário não existir: crie
// atribua esse usuário ao chamado
// persista-o no banco com o ChamadoDAO

?>