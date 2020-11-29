<?php

use yii\db\Migration;

class m201127_085639_0054_create_table_sp_course extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course}}',
            [
                'id' => $this->primaryKey(),
                'course_code' => $this->string(10)->notNull(),
                'course_name' => $this->string(250)->notNull(),
                'course_name_bi' => $this->string(250)->notNull(),
                'credit_hour' => $this->boolean()->notNull(),
                'course_type' => $this->integer()->notNull(),
                'course_level' => $this->boolean()->notNull(),
                'course_class' => $this->integer()->notNull(),
                'faculty_id' => $this->integer()->notNull()->defaultValue('1'),
                'department_id' => $this->integer()->notNull(),
                'program_id' => $this->integer()->notNull(),
                'is_active' => $this->boolean()->notNull()->defaultValue('1'),
                'method_type' => $this->boolean()->notNull()->defaultValue('1')->comment('1=classroom, 2=non-classroom'),
                'is_dummy' => $this->boolean()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
                'component_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_course}}');
    }
}
