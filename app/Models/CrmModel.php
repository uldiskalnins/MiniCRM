<?php

namespace App\Models;

use CodeIgniter\Model;

class CrmModel extends Model
{


    public function countUnitActivitiesHistory($id, $type = 0){//

        $sql = "
            SELECT COUNT(*) AS count_history FROM (

            SELECT id
            FROM mc_calls
            WHERE mc_calls.id IN (
                SELECT call_id
                FROM mc_calls_participants
                WHERE parent_type = $type AND parent_id = $id
            )
            AND mc_calls.status <> 0

            UNION ALL

            SELECT id
            FROM mc_meetings
            WHERE mc_meetings.id IN (
                SELECT meeting_id
                FROM mc_meetings_participants
                WHERE parent_type = $type AND parent_id = $id
            )
            AND mc_meetings.status <> 0

            UNION ALL

            SELECT id
            FROM mc_emails 
            WHERE parent_type = $type AND parent_id =  $id

            ) AS countings
            ";

        $query = $this->db->query($sql);
        return $query->getRow();

    }


    public function getUnitPlannedActivitiesITDUList($id,  $type = 0){//


        $sql = "
        SELECT mc_calls.id, mc_calls.title, mc_calls.user_id, mc_calls.start_date, mc_users.name, CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name', 'c' as activity_type 
        FROM mc_calls
        LEFT JOIN mc_users
        ON mc_calls.user_id = mc_users.id
        WHERE mc_calls.id IN (
            SELECT call_id
            FROM mc_calls_participants
            WHERE parent_type = $type AND parent_id = $id
        )
        AND mc_calls.status = 0


        UNION ALL

        SELECT mc_meetings.id, mc_meetings.title, mc_meetings.user_id, mc_meetings.start_date, mc_users.name, CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name', 'm' as activity_type 
        FROM mc_meetings
        LEFT JOIN mc_users
        ON mc_meetings.user_id = mc_users.id
        WHERE mc_meetings.id IN (
            SELECT meeting_id
            FROM mc_meetings_participants
            WHERE parent_type = $type AND parent_id = $id
        )
        AND mc_meetings.status = 0

        ORDER BY start_date DESC

        ";


    $query = $this->db->query($sql);
    return $query->getResult();

}


    public function getUnitActivitiesHistoryITDUList($id, $limitFrom = 0, $limitLines = 5, $type = 0){//


        $sql = "
        SELECT mc_calls.id, mc_calls.title, mc_calls.user_id, mc_calls.start_date, mc_users.name, CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name', 'c' as activity_type 
        FROM mc_calls
        LEFT JOIN mc_users
        ON mc_calls.user_id = mc_users.id
        WHERE mc_calls.id IN (
            SELECT call_id
            FROM mc_calls_participants
            WHERE parent_type = $type AND parent_id = $id
        )
        AND mc_calls.status <> 0


        UNION ALL

        SELECT mc_meetings.id, mc_meetings.title, mc_meetings.user_id, mc_meetings.start_date, mc_users.name, CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name', 'm' as activity_type 
        FROM mc_meetings
        LEFT JOIN mc_users
        ON mc_meetings.user_id = mc_users.id
        WHERE mc_meetings.id IN (
            SELECT meeting_id
            FROM mc_meetings_participants
            WHERE parent_type = $type AND parent_id = $id
        )
        AND mc_meetings.status <> 0

        UNION ALL

        SELECT mc_emails.id, mc_emails.subject AS title,  mc_emails.user_id, mc_emails.creation_date AS start_date, mc_users.name, CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name', 'e' AS activity_type 
        FROM mc_emails 
        LEFT JOIN mc_users
        ON mc_emails.user_id = mc_users.id
        WHERE parent_type = $type AND parent_id =  $id
        ORDER BY start_date DESC

        LIMIT $limitFrom, $limitLines
        ";


        $query = $this->db->query($sql);
        return $query->getResult();

    }

    public function getAllowedParents($typesId)
    {
        $builder = $this->db->table('mc_posts_parents')
        ->select('*')->whereIn('id', $typesId)->orderBy('id', 'ASC');

        return $builder->get();

    }

    public function getCurencies()
    {
        $builder = $this->db->table('mc_currencies')->select('*') ->orderBy('id', 'ASC');
        return $builder->get();
    }

    public function addCurrency($data)
    {
        return $this->db->table('mc_currencies')->insert($data);
    }

    public function checkCurency($code)
    {
        return $this->db->table('mc_currencies')->select('id')->where('currency_code', $code)->get()->getRow();
    }

    public function deleteCurrency($id)
    {
        return $this->db->table('mc_currencies')->where('id', $id)->delete();
    }

}

?>