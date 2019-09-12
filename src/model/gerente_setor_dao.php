<?php

require_once 'tecnico.php';

class GerenteSetorDAO extends TecnicoDAO
{
    public function create($gerente, $senha)
    {
        $query = "INSERT INTO $this->table (login,nome,email,telefone,senha,cargo,id_setor)
                  VALUES (:login,:nome,:email,:telefone,:senha,'G',:setor)";
        $insertDB = $this->conn->prepare($query);
        $insertDB->bindValue(":login", $gerente->getLogin(), PDO::PARAM_STR);
        $insertDB->bindValue(":nome", $gerente->getNome(), PDO::PARAM_STR);
        $insertDB->bindValue(":email", $gerente->getEmail(), PDO::PARAM_STR);
        $insertDB->bindValue(":telefone", $gerente->getTelefone(), PDO::PARAM_STR);
        $insertDB->bindValue(":setor", $gerente->getSetor()->getID(), PDO::PARAM_INT);
        $hashedSenha = password_hash($senha, PASSWORD_BCRYPT, ['cost' => 12]);
        $insertDB->bindParam(":senha", $hashedSenha, PDO::PARAM_STR);
        $gerente->setSenha($hashedSenha);
        return $insertDB->execute();
    }
}
