<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KalkulatorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'num1' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'num2' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'operator' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
            ],
            'hasil' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('kalkulator');
    }

    public function down()
    {
        $this->forge->dropTable('kalkulator');
    }
}
