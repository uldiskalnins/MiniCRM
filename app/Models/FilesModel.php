<?php

namespace App\Models;

use CodeIgniter\Model;

class FilesModel extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'mc_files';
    protected $allowedFields = [
        'id',
        'file_name',
        'user_id',
        'parent_type',
        'parent_id',
        'creation_date',
    ];




}


?>