<?php

namespace App\Models;

use CodeIgniter\Model;

class MeetingsParticipantsModel extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'mc_meetings_participants';
    protected $allowedFields = [
        'id',
        'meeting_id',
        'parent_type',
        'parent_id'
    ];



    public function getSecondaryParticipant($meetingId = 0, $primaryParentType = 0, $primaryParentId = 0)
    {

        $sql = "
        SELECT
            mc_meetings_participants.*,
           
            CASE 
            WHEN mc_meetings_participants.parent_type = 1 THEN mc_companies.title 
            WHEN mc_meetings_participants.parent_type = 2 THEN CONCAT(mc_persons.name, ' ', mc_persons.surname)
            WHEN mc_meetings_participants.parent_type = 3 THEN CONCAT(mc_leads.name, ' ', mc_leads.surname)
            END AS 'parent_title'

            FROM mc_meetings_participants
            LEFT JOIN mc_companies ON CASE WHEN mc_meetings_participants.parent_type = 1 THEN mc_meetings_participants.parent_id = mc_companies.id ELSE FALSE END
            LEFT JOIN mc_persons ON CASE WHEN mc_meetings_participants.parent_type = 2 THEN mc_meetings_participants.parent_id = mc_persons.id ELSE FALSE END
            LEFT JOIN mc_leads ON CASE WHEN mc_meetings_participants.parent_type = 3 THEN mc_meetings_participants.parent_id = mc_leads.id ELSE FALSE END
            

            WHERE mc_meetings_participants.meeting_id = $meetingId 
            AND NOT (
                mc_meetings_participants.parent_type = $primaryParentType
                AND 
                mc_meetings_participants.parent_id = $primaryParentId 
            )

            ";

        $query = $this->db->query($sql);
        return $query->getRowArray();

    }
}
