<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tugas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'kelas_id' => [
                'type' => 'INT'
            ],
            'tugas_name' => [
                'type' => 'TEXT'
            ],
            'content' => [
                'type' => 'TEXT'
            ],
            'time_limit' => [
                'type' => 'DATETIME'
            ]
        ]);

        $this->forge->addKey('id', TRUE);

        $this->forge->addForeignKey('kelas_id','kelas','id');

        $this->forge->createTable('tugas', TRUE);
        
    }

    public function down()
    {
        $this->forge->dropTable('tugas');
    }
}