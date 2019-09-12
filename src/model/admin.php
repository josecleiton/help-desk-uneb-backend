<?php
require_once "admin_dao.php";
require_once "gerente_setor.php";
class Admin extends GerenteSetor
{
    public function create()
    {
        $dao = new AdminDAO();
        return $dao->create($this, $this->senha);
    }

    public function delete()
    {
        $dao = new AdminDAO();
        return $dao->delete($this);
    }

    // public function getJSON() {
    // $json = parent::getJSON();
    // return $json;
    // }

    public function createSetor($setor)
    {
        return $setor->create();
    }

    public function deleteSetor($setor) {
        return $setor->delete();
    }

    public function createAdmin($admin) {
        return $admin->create();
    }

    public function createGerente($gerente)
    {
        return $gerente->create();
    }

    public function deleteGerente($gerente)
    {
        return $gerente->delete();
    }

    public static function readJWTAndSet($decodedJWT, $admin)
    {
        if (Tecnico::readJWTAndSet($decodedJWT, $admin) && $admin->getCargo() === 'A') {
            return $admin;
        }

        return false;
    }

}
