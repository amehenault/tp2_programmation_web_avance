<?php

require_once __DIR__ . '/../classes/crud.php';

class UserModel extends Crud {

    public function getAll(){
        $users = $this->select('users', 'Nom');

        return $users;
    }
}