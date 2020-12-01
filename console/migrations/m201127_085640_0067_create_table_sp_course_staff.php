<?php

use yii\db\Migration;

class m201127_085640_0067_create_table_sp_course_staff extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_staff}}',
            [
                'id' => $this->primaryKey(),
                'crs_version_id' => $this->integer()->notNull(),
                'staff_id' => $this->integer()->notNull(),
                'staff_order' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('staff_id', '{{%sp_course_staff}}', ['staff_id']);
        $this->createIndex('course_id', '{{%sp_course_staff}}', ['crs_version_id']);
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_staff}}');
    }
}
