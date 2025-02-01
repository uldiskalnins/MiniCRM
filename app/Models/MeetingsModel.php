<?php

namespace App\Models;

use CodeIgniter\Model;

class MeetingsModel extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'mc_meetings';
    protected $allowedFields = [
        'id',
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
        'parent_id',
        'parent_type',
        'user_id',
        'creation_date',
        'edit_date',
    ];




    public function getMeeting($meetingId = 0){

       if($meetingId == 0){return false;}


       $sql = "
       SELECT
            mc_meetings.*,
            CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name',
            CASE 
            WHEN mc_meetings.parent_type = 1 THEN mc_companies.title 
            WHEN mc_meetings.parent_type = 2 THEN CONCAT(mc_persons.name, ' ', mc_persons.surname)
            WHEN mc_meetings.parent_type = 3 THEN CONCAT(mc_leads.name, ' ', mc_leads.surname)
            WHEN mc_meetings.parent_type = 8 THEN mc_opportunities.title 
            END AS 'parent_title'

            FROM mc_meetings
            LEFT JOIN mc_users ON mc_meetings.user_id = mc_users.id
            LEFT JOIN mc_companies ON CASE WHEN mc_meetings.parent_type = 1 THEN mc_meetings.parent_id = mc_companies.id ELSE FALSE END
            LEFT JOIN mc_persons ON CASE WHEN mc_meetings.parent_type = 2 THEN mc_meetings.parent_id = mc_persons.id ELSE FALSE END
            LEFT JOIN mc_leads ON CASE WHEN mc_meetings.parent_type = 3 THEN mc_meetings.parent_id = mc_leads.id ELSE FALSE END
            LEFT JOIN mc_opportunities ON CASE WHEN mc_meetings.parent_type = 8 THEN mc_meetings.parent_id = mc_opportunities.id ELSE FALSE END

            WHERE mc_meetings.id = $meetingId
           ";

       $query = $this->db->query($sql);
       return $query->getRowArray();

    }

    public function getAllMeetingsWithUsers($userId = 0, $limitFrom = 0, $limitLines = 5){



        
        $sql = "
            SELECT

                mc_meetings.*,
                CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name',
                CASE 
                WHEN mc_meetings.parent_type = 1 THEN mc_companies.title 
                WHEN mc_meetings.parent_type = 2 THEN CONCAT(mc_persons.name, ' ', mc_persons.surname) 
                WHEN mc_meetings.parent_type = 3 THEN CONCAT(mc_leads.name, ' ', mc_leads.surname)
                WHEN mc_meetings.parent_type = 8 THEN mc_opportunities.title 
                END AS 'parent_title'

                FROM mc_meetings
                LEFT JOIN mc_users ON mc_meetings.user_id = mc_users.id
                LEFT JOIN mc_companies ON CASE WHEN mc_meetings.parent_type = 1 THEN mc_meetings.parent_id = mc_companies.id ELSE FALSE END
                LEFT JOIN mc_persons ON CASE WHEN mc_meetings.parent_type = 2 THEN mc_meetings.parent_id = mc_persons.id ELSE FALSE END
                LEFT JOIN mc_leads ON CASE WHEN mc_meetings.parent_type = 3 THEN mc_meetings.parent_id = mc_leads.id ELSE FALSE END
                LEFT JOIN mc_opportunities ON CASE WHEN mc_meetings.parent_type = 8 THEN mc_meetings.parent_id = mc_opportunities.id ELSE FALSE END

        ";

         if ($userId != 0){$sql .=' WHERE mc_meetings.user_id = '.$userId;}


        $sql .= " GROUP BY mc_meetings.id ORDER BY mc_meetings.id DESC LIMIT $limitFrom, $limitLines";


        $query = $this->db->query($sql);
        return $query->getResult();


    }

}



?>