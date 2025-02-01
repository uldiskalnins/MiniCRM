<?php

namespace App\Models;

use CodeIgniter\Model;

class CompaniesModel extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'mc_companies';
    protected $allowedFields = [
        'id', 
        'title',
        'reg_nr',
        'vat_nr',
        'email',
        'phone',
        'second_phone',
        'fax',
        'website',
        'bank_title',
        'bank_code',
        'bank_acc_nr',
        'city',
        'country',
        'address1',
        'address2',
        'postal_code',
        'description',
        'creation_date',
        'edit_date',
        'user_id',
        'active',
        'lead_id'
    ];


    public function getCompanyWithUserById($id = 0){

        if($id == 0){return false;}
        $this->select("mc_companies.*, CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name', mc_users.name, mc_users.surname");
        $this->join('mc_users', 'mc_companies.user_id = mc_users.id', 'left');
        $this->where('mc_companies.id', $id);
        return $this->get()->getRowArray();

    }




}



?>