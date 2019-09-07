<?php
require_once('admin_dao.php');
require_once('gerente_setor.php');

class Admin extends GerenteSetor
{
    public function criarAdmin($admin)
    {
        $admin = new admin_dao();
        $admin->insertAdmin($this);
    }

    public function removerAdmin($admin)
    {
        $admin = new admin_dao();
        $admin->deleteAdmin($this);
    }
}
