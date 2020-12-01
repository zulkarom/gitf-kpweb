<?php

use yii\db\Migration;

class m201127_085640_0076_create_table_sp_program_level extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_program_level}}',
            [
                'id' => $this->primaryKey(),
                'code' => $this->boolean()->notNull(),
                'level_name' => $this->string(100)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_program_level}}');
    }
}
