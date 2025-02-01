<?php

namespace App\Models;

use CodeIgniter\Model;

class LeadsModel extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'mc_leads';
    protected $allowedFields = [
        'id', 
        'name',
        'surname',
        'position',
        'email',
        'phone',
        'website',
        'social_network',
        'account',
        'city',
        'country',
        'address1',
        'address2',
        'postal_code',
        'description',
        'status',
        'source',
        'creation_date',
        'edit_date',
        'user_id',
        'active'
    ];


    public function getLeadWithUser($id = 0){

        $this->select("mc_leads.*,  CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name'");
        $this->join('mc_users', 'mc_leads.user_id = mc_users.id', 'left');
        $this->where('mc_leads.id', $id);
        return $this->get()->getRowArray();

    }


}



?>