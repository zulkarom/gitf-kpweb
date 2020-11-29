<?php

use yii\db\Migration;

class m201127_085641_0095_create_table_tld_course_lec extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%tld_course_lec}}',
            [
                'id' => $this->primaryKey(),
                'offered_id' => $this->integer()->notNull(),
                'lec_name' => $this->string(50)->notNull(),
                'student_num' => $this->integer()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%tld_course_lec}}');
    }
}
