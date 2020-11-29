<?php

use yii\db\Migration;

class m201127_085641_0092_create_table_staff_rotate_name extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%staff_rotate_name}}',
            [
                'rotate_id' => $this->primaryKey(),
                'rotate_name' => $this->string(300)->notNull(),
                'rotate_staff' => $this->integer()->notNull(),
                'date_end' => $this->date()->notNull(),
                'date_start' => $this->date()->notNull(),
                'rotate_publish' => $this->boolean()->notNull(),
                'rotate_order' => $this->decimal(11, 1)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%staff_rotate_name}}');
    }
}
