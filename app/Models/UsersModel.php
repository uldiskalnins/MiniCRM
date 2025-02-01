<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'mc_users';
    protected $allowedFields = [
        'id', 
        'password',
        'email',
        'name',
        'surname',
        'phone',
        'position',
        'creation_date',
        'user_rights',
        'edit_date',
        'active'
    ];



    public function usersTableExist()
    {
        return $this->tableExists($this->table);
    }



    function getUserByEmail($email){

        $this->where('email', $email);
        $this->where('active', 1);
        $this->limit(1);
        return $this->get()->getRowArray();
    }



    public function GetUsernameLike($text){

        $this->where('active', 1);
        $this->groupStart();
        $this->like('name', $text);
        $this->orLike('surname', $text);
        $this->groupEnd();
        $this->limit(5);
        return $this->get()->getResultArray();

    }



}



?>