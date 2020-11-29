<?php

use yii\db\Migration;

class m201127_085641_0096_create_table_tld_course_offered extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%tld_course_offered}}',
            [
                'id' => $this->primaryKey(),
                'semester_id' => $this->integer()->notNull(),
                'course_id' => $this->integer()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'created_by' => $this->integer()->notNull(),
                'coordinator' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%tld_course_offered}}');
    }
}
