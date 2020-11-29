<?php

use yii\db\Migration;

class m201127_085640_0074_create_table_sp_program_access extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_program_access}}',
            [
                'id' => $this->primaryKey(),
                'staff_id' => $this->integer()->notNull(),
                'program_id' => $this->integer()->notNull(),
                'acc_order' => $this->integer()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('staff_id', '{{%sp_program_access}}', ['staff_id']);
        $this->createIndex('course_id', '{{%sp_program_access}}', ['program_id']);
    }

    public function down()
    {
        $this->dropTable('{{%sp_program_access}}');
    }
}
