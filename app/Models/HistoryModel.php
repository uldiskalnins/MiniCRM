<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryModel extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'mc_action_history';
    protected $allowedFields = [
        'id',
        'action_type',
        'user_id',
        'parent_type',
        'parent_id',
        'super_parent_type',
        'super_parent_id',
        'creation_date',
        'data',
        'active'

    ];

    public function getHistoryList($id, $limitFrom = 0, $limitLines = 5, $type)
    {
        $builder = $this->db->table('mc_action_history')
            ->select('mc_action_history.*, CONCAT(mc_users.name, " ", mc_users.surname) AS user_full_name')
            ->join('mc_users', 'mc_action_history.user_id = mc_users.id', 'left')
            ->where('parent_type', $type)
            ->where('parent_id', $id);

        $union = $this->db->table('mc_action_history')
            ->select('mc_action_history.*, CONCAT(mc_users.name, " ", mc_users.surname) AS user_full_name')
            ->join('mc_users', 'mc_action_history.user_id = mc_users.id', 'left')
            ->where('super_parent_type', $type)
            ->where('super_parent_id', $id);

        $combinedSql = "({$builder->getCompiledSelect()}) UNION ALL ({$union->getCompiledSelect()}) ORDER BY id DESC LIMIT $limitFrom, $limitLines";

        $query = $this->db->query($combinedSql);
        return $query->getResult();
    }

    public function countHistory($id, $type)
    {
        $sql = "
            SELECT id
            FROM mc_action_history
            WHERE parent_type = $type AND parent_id = $id

            UNION ALL

            SELECT id
            FROM mc_action_history
            WHERE super_parent_type = $type AND super_parent_id = $id
        ";

        $query = $this->db->query($sql);

        return $query->getNumRows();

    }

    public function onlyParentHistoryList($id, $limitFrom = 0, $limitLines = 5, $type)
    {
        $builder = $this->db->table('mc_action_history')
            ->select('
                mc_action_history.id,
                mc_action_history.action_type,
                mc_action_history.user_id,
                mc_action_history.parent_type,
                mc_action_history.parent_id,
                mc_action_history.creation_date,
                mc_action_history.data,
                mc_action_history.active,
                CONCAT(mc_users.name, " ", mc_users.surname) AS user_full_name
                ')
            ->join('mc_users', 'mc_action_history.user_id = mc_users.id', 'left')
            ->where('parent_type', $type)
            ->where('parent_id', $id)
            ->orderBy('id', 'DESC')
            ->limit($limitLines, $limitFrom);
    
        return $builder->get()->getResult();

    }
    public function countOnlyParentHistory($id, $type)
    {
        $builder = $this->db->table('mc_action_history')
            ->select('id')
            ->where('parent_type', $type)
            ->where('parent_id', $id);
        return $builder->get()->getNumRows();

    }

}


?>