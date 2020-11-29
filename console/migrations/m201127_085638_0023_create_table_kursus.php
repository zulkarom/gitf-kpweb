<?php

use yii\db\Migration;

class m201127_085638_0023_create_table_kursus extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%kursus}}',
            [
                'id' => $this->primaryKey(),
                'code' => $this->string(8),
                'name' => $this->string(53),
                'name2' => $this->string(52),
                'credit' => $this->integer(2),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%kursus}}');
    }
}
