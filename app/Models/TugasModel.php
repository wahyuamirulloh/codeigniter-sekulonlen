<?php
namespace App\Models;

use CodeIgniter\Model;

class TugasModel extends Model
{
    protected $table = 'tugas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kelas_id', 'tugas_name', 'content', 'time_limit'];
    protected $returnType = 'App\Entities\Tugas';
    protected $useTimestamps = false;

    public function listing()
    {
        $this->select(['tugas.*', 'kelas.kelas_bgcolor', 'kelas.kelas_name']);
        $this->join('kelas', 'kelas.id = tugas.kelas_id');
        $this->orderBy('time_limit', 'ASC');
        $query = $this->get();
        return $query->getResultArray();
    }
}