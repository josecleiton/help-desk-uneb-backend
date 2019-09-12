<?php
require_once('tecnico_dao.php');
require_once('admin.php');
require_once('tecnico.php');

class AdminDAO extends TecnicoDAO
{
    public function create($admin, $senha)
    {
        $query = "INSERT INTO $this->table (login,nome,email,telefone,senha,cargo)
         VALUES (:login,:nome,:email,:telefone,:senha,'A')";
        $insertDB = $this->conn->prepare($query);
        $insertDB->bindValue(":login", $admin->getLogin(), PDO::PARAM_STR);
        $insertDB->bindValue(":nome", $admin->getNome(), PDO::PARAM_STR);
        $insertDB->bindValue(":email", $admin->getEmail(), PDO::PARAM_STR);
        $insertDB->bindValue(":telefone", $admin->getTelefone(), PDO::PARAM_STR);
        $hashedSenha = password_hash($senha, PASSWORD_BCRYPT, ['cost' => 12]);
        $insertDB->bindParam(":senha", $hashedSenha, PDO::PARAM_STR);
        $admin->setSenha($hashedSenha);
        return $insertDB->execute();
    }
}
