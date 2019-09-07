<?php
require_once("dao.php");
require_once('admin.php');
require_once('tecnico.php');

class admin_dao extends DAO
{
    //const TABLE = "talteracao";

    public function insertAdmin($admin)
    {
        $query = "INSERT INTO ttecnico (login,nome,email,telefone,id_setor, cargo)
         VALUES (:login,:nome,:email,:telefone,:id_setor,'A')";
        $insertDB = $this->conn->prepare($query);
        $insertDB->bindValue("login", $login);
        $insertDB->bindValue("nome", $nome);
        $insertDB->bindValue("email", $email);
        $insertDB->bindValue("telefone", $telefone);
        $insertDB->bindValue("id_setor", $idSetor);
        $insertDB->bindValue("cargo", $cargo);
        $login = $admin->getLogin();
        $nome = $admin->getNome();
        $email = $admin->getEmail();
        $telefone = $admin->getTelefone();
        $idSetor = $admin->getSetor();

        if ($insertDB->execute()) {
            $admin->setID($this->conn->lastInsertId());
            return $insertDB->rowCount();
        }
        return 0;
    }
    public function deleteAdmin($admin)
    {
        $query = "DELETE FROM ttecnico WHERE [nome=$nome AND login=$login]";
        $deleteDB = $this->conn->prepare($query);
        $nome = $admin->getNome();
        $login = $admin->getLogin();
        if ($deleteDB->execute()) {
            $admin->setID($this->conn->lastInsertId());
            return $deleteDB->rowCount();
        }
        return 0;
    }
}
