
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once dirname(__FILE__) . '/../../model/gerente_setor.php';
require_once dirname(__FILE__) . '/../../model/admin.php';
require_once dirname(__FILE__) . '/../../model/request.php';

// var_dump(Admin::readJWT(Request::getAuthToken()));
// var_dump(Request::getAuthToken());
$admin = new Admin();
if (!Admin::readJWTAndSet(Request::getAuthToken(), $admin)) {
    echo json_encode(array(
        "error" => 400,
        "mensagem" => "Você não está autenticado",
    ));
    return false;
}

$data = json_decode(file_get_contents("php://input"));

?>