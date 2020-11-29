<?php

use yii\db\Migration;

class m201127_085640_0072_create_table_sp_course_version extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_version}}',
            [
                'id' => $this->primaryKey(),
                'course_id' => $this->integer()->notNull(),
                'version_name' => $this->string(200)->notNull(),
                'version_type_id' => $this->integer()->notNull(),
                'status' => $this->tinyInteger(4)->notNull(),
                'is_developed' => $this->boolean()->notNull(),
                'is_published' => $this->boolean()->notNull(),
                'trash' => $this->boolean()->notNull(),
                'created_by' => $this->integer()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
                'senate_approve_show' => $this->boolean()->notNull(),
                'final_week' => $this->string(20)->notNull(),
                'syllabus_break' => $this->text()->notNull()->defaultValue('\'["7"]\''),
                'study_week' => $this->string(20)->notNull(),
                'prepared_by' => $this->integer()->notNull(),
                'prepared_at' => $this->date()->notNull(),
                'verified_by' => $this->integer()->notNull(),
                'verified_at' => $this->date()->notNull(),
                'faculty_approve_at' => $this->date()->notNull(),
                'senate_approve_at' => $this->date()->notNull(),
                'pgrs_info' => $this->boolean()->notNull(),
                'pgrs_clo' => $this->boolean()->notNull(),
                'pgrs_plo' => $this->boolean()->notNull(),
                'pgrs_tax' => $this->boolean()->notNull(),
                'pgrs_soft' => $this->boolean()->notNull(),
                'pgrs_delivery' => $this->boolean()->notNull(),
                'pgrs_syll' => $this->boolean()->notNull(),
                'pgrs_slt' => $this->boolean()->notNull(),
                'pgrs_assess' => $this->boolean()->notNull(),
                'pgrs_assess_per' => $this->boolean()->notNull(),
                'pgrs_ref' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_version}}');
    }
}
