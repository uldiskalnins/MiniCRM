<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonsModel extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'mc_persons';
    protected $allowedFields = [
        'id', 
        'name',
        'surname',
        'nin',
        'position',
        'email',
        'phone',
        'second_phone',
        'fax',
        'website',
        'facebook',
        'birthday',
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
        'company_id',
        'active',
        'lead_id'
    ];





    public function getPersonWithUserAndCompanyById($id = 0){

        if($id == 0){return false;}
        $this->select("mc_persons.*, mc_companies.title,  mc_users.name AS 'user_name', mc_users.surname AS 'user_surname'");
        $this->join('mc_users', 'mc_persons.user_id = mc_users.id', 'left');
        $this->join('mc_companies', 'mc_persons.company_id = mc_companies.id','left');
        $this->where('mc_persons.id', $id);
        return $this->get()->getRowArray();

    }

    public function getPersonsWithNearbyBirthdays($userId = 0)  
    {

        $sql = "
        SELECT id, birthday, CONCAT(name, ' ', surname) AS 'full_name'
        FROM 
            mc_persons
        WHERE 
            ((MONTH(birthday) = MONTH(CURDATE()) AND DAY(birthday) = DAY(CURDATE()))
            OR (MONTH(birthday) = MONTH(DATE_ADD(CURDATE(), INTERVAL 1 DAY)) AND DAY(birthday) = DAY(DATE_ADD(CURDATE(), INTERVAL 1 DAY)))
            OR (MONTH(birthday) = MONTH(DATE_ADD(CURDATE(), INTERVAL 2 DAY)) AND DAY(birthday) = DAY(DATE_ADD(CURDATE(), INTERVAL 2 DAY))))
            AND user_id = $userId 
        ORDER BY DAYOFYEAR(birthday) ASC
        ";


    $query = $this->db->query($sql);
    return $query->getResult();
    }


}



?>