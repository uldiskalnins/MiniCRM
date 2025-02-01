<?php

namespace App\Models;

use CodeIgniter\Model;

class EmailsModel extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'mc_emails';
    protected $allowedFields = [
        'id',
        'subject',
        'body',
        'from_email',
        'from_name',
        'to_email',
        'cc',
        'bcc',
        'action_type',
        'user_id',
        'parent_type',
        'parent_id',
        'edit_date',
        'creation_date'
    ];


    public function getEmail($emailId = 0)
    {


        $sql = "
            SELECT
                mc_emails.*, CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name',

            CASE 
            WHEN mc_emails.parent_type = 1 THEN mc_companies.title 
            WHEN mc_emails.parent_type = 2 THEN CONCAT(mc_persons.name, ' ', mc_persons.surname) 
            WHEN mc_emails.parent_type = 3 THEN CONCAT(mc_leads.name, ' ', mc_leads.surname)
            WHEN mc_emails.parent_type = 8 THEN mc_opportunities.title 
            END AS 'parent_title'

            FROM mc_emails
            LEFT JOIN mc_users ON mc_emails.user_id = mc_users.id
            LEFT JOIN mc_companies ON CASE WHEN mc_emails.parent_type = 1 THEN  mc_emails.parent_id = mc_companies.id ELSE FALSE END
            LEFT JOIN mc_persons ON CASE WHEN mc_emails.parent_type = 2 THEN  mc_emails.parent_id = mc_persons.id ELSE FALSE END
            LEFT JOIN mc_leads ON CASE WHEN mc_emails.parent_type = 3 THEN  mc_emails.parent_id = mc_leads.id ELSE FALSE END 
            LEFT JOIN mc_opportunities ON CASE WHEN mc_emails.parent_type = 8 THEN mc_emails.parent_id = mc_opportunities.id ELSE FALSE END

            WHERE mc_emails.id = $emailId
        ";

        $query = $this->db->query($sql);
        return $query->getRowArray();
    }



    public function getAllEmailsWithUser($userId = 0, $limitFrom = 0, $limitLines = 5)
    {

        $sql = "
            SELECT
                mc_emails.*, CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name',


            CASE 
            WHEN mc_emails.parent_type = 1 THEN mc_companies.title 
            WHEN mc_emails.parent_type = 2 THEN CONCAT(mc_persons.name, ' ', mc_persons.surname) 
            WHEN mc_emails.parent_type = 3 THEN CONCAT(mc_leads.name, ' ', mc_leads.surname)
            WHEN mc_emails.parent_type = 8 THEN mc_opportunities.title 

            END AS 'parent_title'

            FROM mc_emails
            LEFT JOIN mc_users ON mc_emails.user_id = mc_users.id
            LEFT JOIN mc_companies ON CASE WHEN mc_emails.parent_type = 1 THEN  mc_emails.parent_id = mc_companies.id ELSE FALSE END
            LEFT JOIN mc_persons ON CASE WHEN mc_emails.parent_type = 2 THEN  mc_emails.parent_id = mc_persons.id ELSE FALSE END
            LEFT JOIN mc_leads ON CASE WHEN mc_emails.parent_type = 3 THEN  mc_emails.parent_id = mc_leads.id ELSE FALSE END 
            LEFT JOIN mc_opportunities ON CASE WHEN mc_emails.parent_type = 8 THEN mc_emails.parent_id = mc_opportunities.id ELSE FALSE END

        ";

        if ($userId != 0) {
            $sql = $sql . ' WHERE mc_emails.user_id = ' . $userId;
        }

        $sql = $sql . " 
                GROUP BY mc_emails.id
                ORDER BY mc_emails.id DESC
                LIMIT $limitLines OFFSET $limitFrom
        ";


        $query = $this->db->query($sql);
        return $query->getResult();
    }
}
