<?php

namespace App\Models;

use CodeIgniter\Model;

class CallsModel extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'mc_calls';
    protected $allowedFields = [
        'id',
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
        'type',
        'user_id',
        'creation_date',
        'edit_date',
        'parent_type',
        'parent_id'
    ];


    public function getCall($callId = 0){

        if($callId == 0){return false;}

        $sql = "
        SELECT
            mc_calls.*,
            CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name',
            CASE 
            WHEN mc_calls.parent_type = 1 THEN mc_companies.title 
            WHEN mc_calls.parent_type = 2 THEN CONCAT(mc_persons.name, ' ', mc_persons.surname)
            WHEN mc_calls.parent_type = 3 THEN CONCAT(mc_leads.name, ' ', mc_leads.surname)
            WHEN mc_calls.parent_type = 8 THEN mc_opportunities.title 
            END AS 'parent_title'

            FROM mc_calls
            LEFT JOIN mc_users ON mc_calls.user_id = mc_users.id
            LEFT JOIN mc_companies ON CASE WHEN mc_calls.parent_type = 1 THEN mc_calls.parent_id = mc_companies.id ELSE FALSE END
            LEFT JOIN mc_persons ON CASE WHEN mc_calls.parent_type = 2 THEN mc_calls.parent_id = mc_persons.id ELSE FALSE END
            LEFT JOIN mc_leads ON CASE WHEN mc_calls.parent_type = 3 THEN mc_calls.parent_id = mc_leads.id ELSE FALSE END
            LEFT JOIN mc_opportunities ON CASE WHEN mc_calls.parent_type = 8 THEN mc_calls.parent_id = mc_opportunities.id ELSE FALSE END


            WHERE mc_calls.id = $callId
            ";

        $query = $this->db->query($sql);
        return $query->getRowArray();

    }

    public function getAllCallsWithUsers($userId = 0, $limitFrom = 0, $limitLines = 5){


        $sql = "
            SELECT

                mc_calls.*, CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name',

                CASE 
                WHEN mc_calls.parent_type = 1 THEN mc_companies.title 
                WHEN mc_calls.parent_type = 2 THEN CONCAT(mc_persons.name, ' ', mc_persons.surname) 
                WHEN mc_calls.parent_type = 3 THEN CONCAT(mc_leads.name, ' ', mc_leads.surname)
                WHEN mc_calls.parent_type = 8 THEN mc_opportunities.title 
                END AS 'parent_title',
                
                CASE 
                WHEN mc_calls.parent_type = 1 THEN mc_companies.active 
                WHEN mc_calls.parent_type = 2 THEN mc_persons.active 
                WHEN mc_calls.parent_type = 3 THEN mc_leads.active
                WHEN mc_calls.parent_type = 8 THEN mc_opportunities.active
                END AS 'parent_active'

                FROM mc_calls
                LEFT JOIN mc_users ON mc_calls.user_id = mc_users.id
                LEFT JOIN mc_companies ON CASE WHEN mc_calls.parent_type = 1 THEN mc_calls.parent_id = mc_companies.id ELSE FALSE END
                LEFT JOIN mc_persons ON CASE WHEN mc_calls.parent_type = 2 THEN mc_calls.parent_id = mc_persons.id ELSE FALSE END
                LEFT JOIN mc_leads ON CASE WHEN mc_calls.parent_type = 3 THEN mc_calls.parent_id = mc_leads.id ELSE FALSE END
                LEFT JOIN mc_opportunities ON CASE WHEN mc_calls.parent_type = 8 THEN mc_calls.parent_id = mc_opportunities.id ELSE FALSE END

        ";

        if ($userId != 0)
        {
            $sql .=' WHERE mc_calls.user_id = '.$userId ;
            $sql .= " AND (mc_companies.active = 1 OR mc_persons.active = 1 OR mc_leads.active = 1 OR mc_opportunities.active = 1) ";
        }


        $sql .= " GROUP BY mc_calls.id ORDER BY mc_calls.id DESC LIMIT $limitFrom, $limitLines";


        $query = $this->db->query($sql);
        return $query->getResult();


    }

    public function countCallsWithActiveParent($userId = 0){


        $sql = "
            SELECT mc_calls.id 

                FROM mc_calls
                LEFT JOIN mc_companies ON CASE WHEN mc_calls.parent_type = 1 THEN mc_calls.parent_id = mc_companies.id ELSE FALSE END
                LEFT JOIN mc_persons ON CASE WHEN mc_calls.parent_type = 2 THEN mc_calls.parent_id = mc_persons.id ELSE FALSE END
                LEFT JOIN mc_leads ON CASE WHEN mc_calls.parent_type = 3 THEN mc_calls.parent_id = mc_leads.id ELSE FALSE END
                LEFT JOIN mc_opportunities ON CASE WHEN mc_calls.parent_type = 8 THEN mc_calls.parent_id = mc_opportunities.id ELSE FALSE END

        ";

        if ($userId != 0)
        {
            $sql .=' WHERE mc_calls.user_id = '.$userId ;
            $sql .= " AND (mc_companies.active = 1 OR mc_persons.active = 1 OR mc_leads.active = 1 OR mc_opportunities.active = 1) ";


        }

        $query = $this->db->query($sql);
        return $query->getNumRows();


    }


}



?>