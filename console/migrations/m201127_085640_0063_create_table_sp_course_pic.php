<?php

use yii\db\Migration;

class m201127_085640_0063_create_table_sp_course_pic extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_pic}}',
            [
                'id' => $this->primaryKey(),
                'course_id' => $this->integer()->notNull(),
                'staff_id' => $this->integer()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
                'pic_order' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('staff_id', '{{%sp_course_pic}}', ['staff_id']);
        $this->createIndex('course_id', '{{%sp_course_pic}}', ['course_id']);
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_pic}}');
    }
}
