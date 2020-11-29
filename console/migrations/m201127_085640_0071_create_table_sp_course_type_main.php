<?php

use yii\db\Migration;

class m201127_085640_0071_create_table_sp_course_type_main extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_type_main}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(50)->notNull(),
                'name_bi' => $this->string(50)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_type_main}}');
    }
}
