<?php

namespace App\Models;

use CodeIgniter\Model;

class CallsParticipantsModel extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'mc_calls_participants';
    protected $allowedFields = [
        'id',
        'call_id',
        'parent_type',
        'parent_id'
    ];



    public function getSecondaryParticipant($callId = 0, $primaryParentType = 0, $primaryParentId = 0){

        if($callId == 0){return false;}

        $sql = "
        SELECT
            mc_calls_participants.*,
           
            CASE 
            WHEN mc_calls_participants.parent_type = 1 THEN mc_companies.title 
            WHEN mc_calls_participants.parent_type = 2 THEN CONCAT(mc_persons.name, ' ', mc_persons.surname)
            WHEN mc_calls_participants.parent_type = 3 THEN CONCAT(mc_leads.name, ' ', mc_leads.surname)
            END AS 'parent_title'

            FROM mc_calls_participants
            LEFT JOIN mc_companies ON CASE WHEN mc_calls_participants.parent_type = 1 THEN mc_calls_participants.parent_id = mc_companies.id ELSE FALSE END
            LEFT JOIN mc_persons ON CASE WHEN mc_calls_participants.parent_type = 2 THEN mc_calls_participants.parent_id = mc_persons.id ELSE FALSE END
            LEFT JOIN mc_leads ON CASE WHEN mc_calls_participants.parent_type = 3 THEN mc_calls_participants.parent_id = mc_leads.id ELSE FALSE END

            WHERE mc_calls_participants.call_id = $callId 
            
            AND NOT (
                mc_calls_participants.parent_type = $primaryParentType
                AND 
                mc_calls_participants.parent_id = $primaryParentId 
            )

            ";

        $query = $this->db->query($sql);
        return $query->getRowArray();


    }

}



?>