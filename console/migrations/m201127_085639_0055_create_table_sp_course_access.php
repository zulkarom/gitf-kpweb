<?php

use yii\db\Migration;

class m201127_085639_0055_create_table_sp_course_access extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_access}}',
            [
                'id' => $this->primaryKey(),
                'staff_id' => $this->integer()->notNull(),
                'course_id' => $this->integer()->notNull(),
                'acc_order' => $this->integer()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('staff_id', '{{%sp_course_access}}', ['staff_id']);
        $this->createIndex('course_id', '{{%sp_course_access}}', ['course_id']);
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_access}}');
    }
}
