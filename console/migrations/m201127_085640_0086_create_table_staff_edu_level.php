<?php

use yii\db\Migration;

class m201127_085640_0086_create_table_staff_edu_level extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%staff_edu_level}}',
            [
                'id' => $this->primaryKey(),
                'level_name' => $this->string(100)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%staff_edu_level}}');
    }
}