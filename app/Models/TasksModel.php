<?php

namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'mc_tasks';
    protected $allowedFields = [
        'id',
        'title',
        'description',
        'status',
        'start_date',
        'end_date',
        'priority',
        'creation_date',
        'edit_date',
        'user_id',
        'parent_type',
        'parent_id'
    ];



    public function getUnitTasksList($id = 0, $limitFrom = 0, $limitLines = 5, $type = 0)
    {

        if ($id == 0) {return false;}

        $builder = $this->db->table('mc_tasks');
        $builder->select("mc_tasks.*, CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name'");
        $builder->join('mc_users', 'mc_tasks.user_id = mc_users.id', 'left');

        return $builder->where('mc_tasks.parent_id', $id)->where('mc_tasks.parent_type', $type)->orderBy('id', 'DESC')->limit($limitLines, $limitFrom)->get()->getResult();
    }


    public function countUnitTasks($id = 0, $type = 0)
    {

        if ($id == 0) {return false;}

        $builder = $this->db->table('mc_tasks');
        $builder->select("mc_tasks.*,mc_users.name AS 'user_name', mc_users.surname AS 'user_surname'");
        $builder->join('mc_users', 'mc_tasks.user_id = mc_users.id', 'left');

        return $builder->where('mc_tasks.parent_id', $id)->where('mc_tasks.parent_type', $type)->countAllResults();
    }



    public function getTask($taskId = 0)
    {

        $sql = "
        SELECT 
            mc_tasks.*, CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name',

            CASE 
            WHEN mc_tasks.parent_type = 1 THEN mc_companies.title 
            WHEN mc_tasks.parent_type = 2 THEN CONCAT(mc_persons.name, ' ', mc_persons.surname) 
            WHEN mc_tasks.parent_type = 3 THEN CONCAT(mc_leads.name, ' ', mc_leads.surname)
            WHEN mc_tasks.parent_type = 8 THEN mc_opportunities.title 
            END AS 'parent_title'

            FROM mc_tasks
            LEFT JOIN mc_users ON mc_tasks.user_id = mc_users.id
            LEFT JOIN mc_companies ON CASE WHEN mc_tasks.parent_type = 1 THEN mc_tasks.parent_id = mc_companies.id ELSE FALSE END
            LEFT JOIN mc_persons ON CASE WHEN mc_tasks.parent_type = 2 THEN mc_tasks.parent_id = mc_persons.id ELSE FALSE END
            LEFT JOIN mc_leads ON CASE WHEN mc_tasks.parent_type = 3 THEN mc_tasks.parent_id = mc_leads.id ELSE FALSE END
            LEFT JOIN mc_opportunities ON CASE WHEN mc_tasks.parent_type = 8 THEN mc_tasks.parent_id = mc_opportunities.id ELSE FALSE END

            WHERE mc_tasks.id = $taskId

        ";

        $query = $this->db->query($sql);
        return $query->getRowArray();
    }




    public function getAllTasksWithUser($userId = 0, $limitFrom = 0, $limitLines = 5)
    {

        $sql = "
        SELECT 

            mc_tasks.*, 
            CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name',

            CASE 
                WHEN mc_tasks.parent_type = 1 THEN mc_companies.title 
                WHEN mc_tasks.parent_type = 2 THEN CONCAT(mc_persons.name, ' ', mc_persons.surname) 
                WHEN mc_tasks.parent_type = 3 THEN CONCAT(mc_leads.name, ' ', mc_leads.surname)
                WHEN mc_tasks.parent_type = 8 THEN mc_opportunities.title 
            END AS 'parent_title'

        FROM mc_tasks
            LEFT JOIN mc_users ON mc_tasks.user_id = mc_users.id
            LEFT JOIN mc_companies ON CASE WHEN mc_tasks.parent_type = 1 THEN mc_tasks.parent_id = mc_companies.id ELSE FALSE END
            LEFT JOIN mc_persons ON CASE WHEN mc_tasks.parent_type = 2 THEN mc_tasks.parent_id = mc_persons.id ELSE FALSE END
            LEFT JOIN mc_leads ON CASE WHEN mc_tasks.parent_type = 3 THEN mc_tasks.parent_id = mc_leads.id ELSE FALSE END
            LEFT JOIN mc_opportunities ON CASE WHEN mc_tasks.parent_type = 8 THEN mc_tasks.parent_id = mc_opportunities.id ELSE FALSE END
        ";

        if ($userId > 0) {
            $sql .= ' WHERE mc_tasks.user_id = ' . $userId . '
            ';
        }

        $sql .='
            GROUP BY mc_tasks.id
            ORDER BY mc_tasks.id DESC 
            LIMIT ' . $limitLines . ' OFFSET ' . $limitFrom . '
            ';


        $query = $this->db->query($sql);
        return $query->getResult();
    }


}
