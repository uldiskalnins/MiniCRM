<?php

namespace App\Models;

use CodeIgniter\Model;

class OpportunitiesModel extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'mc_opportunities';
    protected $allowedFields = [
        'id', 
        'title',
        'description',
        'stage',
        'amount',
        'probability',
        'currency',
        'close_date',
        'parent_id',
        'parent_type',
        'lead_source',
        'creation_date',
        'edit_date',
        'user_id',
        'active'
    ];

    public function getOpportunity($opportunityId = 0){

        if($opportunityId == 0){return false;}

        $sql = "
        SELECT
            mc_opportunities.*,
            CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name',
            CASE 
            WHEN mc_opportunities.parent_type = 1 THEN mc_companies.title 
            WHEN mc_opportunities.parent_type = 2 THEN CONCAT(mc_persons.name, ' ', mc_persons.surname)
            WHEN mc_opportunities.parent_type = 3 THEN CONCAT(mc_leads.name, ' ', mc_leads.surname)
            END AS 'parent_title'

            FROM mc_opportunities
            LEFT JOIN mc_users ON mc_opportunities.user_id = mc_users.id
            LEFT JOIN mc_companies ON CASE WHEN mc_opportunities.parent_type = 1 THEN mc_opportunities.parent_id = mc_companies.id ELSE FALSE END
            LEFT JOIN mc_persons ON CASE WHEN mc_opportunities.parent_type = 2 THEN mc_opportunities.parent_id = mc_persons.id ELSE FALSE END
            LEFT JOIN mc_leads ON CASE WHEN mc_opportunities.parent_type = 3 THEN mc_opportunities.parent_id = mc_leads.id ELSE FALSE END

            WHERE mc_opportunities.id = $opportunityId
            ";

        $query = $this->db->query($sql);
        return $query->getRowArray();


    }



    public function getAllOpportunitiesWithUsers($userId = 0, $limitFrom = 0, $limitLines = 5){


        $sql = "
            SELECT

                mc_opportunities.*,
                CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name',

                CASE 
                WHEN mc_opportunities.parent_type = 1 THEN mc_companies.title 
                WHEN mc_opportunities.parent_type = 2 THEN CONCAT(mc_persons.name, ' ', mc_persons.surname) 
                WHEN mc_opportunities.parent_type = 3 THEN CONCAT(mc_leads.name, ' ', mc_leads.surname)
                END AS 'parent_title',
                
                CASE 
                WHEN mc_opportunities.parent_type = 1 THEN mc_companies.active 
                WHEN mc_opportunities.parent_type = 2 THEN mc_persons.active 
                WHEN mc_opportunities.parent_type = 3 THEN mc_leads.active
                END AS 'parent_active'

                FROM mc_opportunities
                LEFT JOIN mc_users ON mc_opportunities.user_id = mc_users.id
                LEFT JOIN mc_companies ON CASE WHEN mc_opportunities.parent_type = 1 THEN mc_opportunities.parent_id = mc_companies.id ELSE FALSE END
                LEFT JOIN mc_persons ON CASE WHEN mc_opportunities.parent_type = 2 THEN mc_opportunities.parent_id = mc_persons.id ELSE FALSE END
                LEFT JOIN mc_leads ON CASE WHEN mc_opportunities.parent_type = 3 THEN mc_opportunities.parent_id = mc_leads.id ELSE FALSE END

        ";

        if ($userId != 0){$sql .=' WHERE mc_opportunities.active = 1 AND mc_opportunities.user_id = '.$userId;}


        $sql .= " GROUP BY mc_opportunities.id ORDER BY mc_opportunities.id DESC LIMIT $limitFrom, $limitLines";


        $query = $this->db->query($sql);
        return $query->getResult();


    }

    public function getLastTwelveMonthOpportunitiesAmount($userId = 0){
    ///jāpārtaisa lai tiktu ņemtu vērā valūtu kursi

        $sql = "
            SELECT
                CONCAT(YEAR(close_date), ' ', LEFT(MONTHNAME(close_date), 3)) AS month_year, 
                SUM(amount) AS total_amount
            FROM
                mc_opportunities
            ";

        if($userId != 0)
        {
            $sql .= " 
            WHERE
                user_id = $userId 
                AND close_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
                AND stage = 4 
            ";
        }
        else{
            $sql .= " 
            WHERE
                close_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
                AND stage = 4 
            ";
        }

        $sql .= " 
            GROUP BY 
                YEAR(close_date), MONTH(close_date)
            ORDER BY 
                YEAR(close_date) ASC, MONTH(close_date) ASC;

        ";

        $query = $this->db->query($sql);
        return $query->getResultArray();

    }


}



?>