<?php

use yii\db\Migration;

class m201127_085641_0093_create_table_staff_working_status extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%staff_working_status}}',
            [
                'id' => $this->primaryKey(),
                'work_name' => $this->string(300)->notNull(),
                'work_order' => $this->decimal(3, 1)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%staff_working_status}}');
    }
}
