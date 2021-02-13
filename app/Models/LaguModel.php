<?php

namespace App\Models;

use CodeIgniter\Model;

class LaguModel extends Model
{
    protected $table = 'tb_lagu';
    protected $useTimestamps = false;
    protected $allowedFields = ['Number', 'Genre', 'Artist', 'Year', 'Album', 'Song'];
    protected $primaryKey = 'Number';


    public function getData($term, $key)
    {
        $builder = $this->db->table($this->table);
        $builder->select($key);
        $builder->like($key, $term);
        $builder->distinct();
        $builder->limit(10);
        return $builder->get()->getResultArray();
    }
}
