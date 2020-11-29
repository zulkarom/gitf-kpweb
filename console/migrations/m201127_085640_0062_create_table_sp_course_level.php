<?php

use yii\db\Migration;

class m201127_085640_0062_create_table_sp_course_level extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_level}}',
            [
                'id' => $this->primaryKey(),
                'lvl_name' => $this->string(100)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_level}}');
    }
}
