<?php

use yii\db\Migration;

class m201127_085640_0084_create_table_staff extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%staff}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'staff_no' => $this->char(10)->notNull(),
                'staff_title' => $this->string(20)->notNull(),
                'faculty_id' => $this->integer()->notNull(),
                'staff_edu' => $this->string(300)->notNull(),
                'is_academic' => $this->tinyInteger(4)->notNull(),
                'nationality' => $this->string(10)->notNull()->defaultValue('MY'),
                'position_id' => $this->integer(5)->notNull(),
                'position_status' => $this->integer()->notNull(),
                'working_status' => $this->integer(5)->notNull()->defaultValue('1'),
                'leave_start' => $this->date()->notNull(),
                'leave_end' => $this->date()->notNull(),
                'leave_note' => $this->text()->notNull(),
                'rotation_post' => $this->string(500)->notNull(),
                'staff_expertise' => $this->string(300)->notNull(),
                'staff_gscholar' => $this->string(500)->notNull(),
                'officephone' => $this->string(20)->notNull(),
                'handphone1' => $this->string(20)->notNull(),
                'handphone2' => $this->string(20)->notNull(),
                'staff_ic' => $this->string(15)->notNull(),
                'staff_dob' => $this->date(),
                'date_begin_umk' => $this->date(),
                'date_begin_service' => $this->date(),
                'staff_note' => $this->string(100)->notNull(),
                'personal_email' => $this->string(100)->notNull(),
                'ofis_location' => $this->string(100)->notNull(),
                'staff_cv' => $this->string(300)->notNull(),
                'image_file' => $this->string()->notNull(),
                'staff_level' => $this->integer(1)->notNull(),
                'staff_interest' => $this->text()->notNull(),
                'staff_department' => $this->integer()->notNull(),
                'research_focus' => $this->text()->notNull(),
                'trash' => $this->boolean()->notNull()->defaultValue('0'),
                'publish' => $this->boolean()->notNull()->defaultValue('1'),
                'staff_active' => $this->boolean()->notNull()->defaultValue('1'),
                'high_qualification' => $this->string(10)->notNull(),
                'hq_specialization' => $this->string(100)->notNull(),
                'hq_year' => $this->date()->notNull(),
                'hq_country' => $this->string(10)->notNull(),
                'hq_institution' => $this->string(200)->notNull(),
                'teaching_submit' => $this->boolean()->notNull(),
                'teaching_submit_at' => $this->dateTime()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('staff_id', '{{%staff}}', ['id'], true);
    }

    public function down()
    {
        $this->dropTable('{{%staff}}');
    }
}
