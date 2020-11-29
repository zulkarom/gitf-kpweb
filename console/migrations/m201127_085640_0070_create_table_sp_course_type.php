<?php

use yii\db\Migration;

class m201127_085640_0070_create_table_sp_course_type extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_type}}',
            [
                'id' => $this->primaryKey(),
                'type_name' => $this->string(250)->notNull(),
                'main_type' => $this->boolean()->notNull(),
                'type_order' => $this->tinyInteger(4)->notNull(),
                'showing' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_type}}');
    }
}
