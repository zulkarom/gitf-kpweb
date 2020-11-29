<?php

use yii\db\Migration;

class m201127_085640_0061_create_table_sp_course_delivery extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_delivery}}',
            [
                'id' => $this->primaryKey(),
                'delivery_name' => $this->string(50)->notNull(),
                'delivery_name_bi' => $this->string(50)->notNull(),
                'is_main' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_delivery}}');
    }
}
