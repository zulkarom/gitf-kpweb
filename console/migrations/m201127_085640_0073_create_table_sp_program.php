<?php

use yii\db\Migration;

class m201127_085640_0073_create_table_sp_program extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_program}}',
            [
                'id' => $this->primaryKey(),
                'pro_name' => $this->string(250)->notNull(),
                'pro_name_bi' => $this->string(250)->notNull(),
                'program_code' => $this->string(50)->notNull(),
                'pro_level' => $this->boolean()->notNull()->comment('4=diploma,6=sarjana muda, 7=sarjana,8=phd'),
                'faculty_id' => $this->integer()->notNull()->defaultValue('1'),
                'department_id' => $this->integer()->notNull(),
                'status' => $this->boolean()->notNull()->comment('0=under development,1=offered'),
                'pro_cat' => $this->integer()->notNull()->defaultValue('1'),
                'pro_field' => $this->integer()->notNull(),
                'grad_credit' => $this->tinyInteger()->notNull(),
                'prof_body' => $this->string(250)->notNull(),
                'coll_inst' => $this->string(250)->notNull(),
                'study_mode' => $this->boolean()->notNull()->comment('1=coursework,2=mix,3=research'),
                'sesi_start' => $this->string(250)->notNull(),
                'pro_sustain' => $this->text()->notNull(),
                'full_week_long' => $this->tinyInteger()->notNull(),
                'full_week_short' => $this->tinyInteger()->notNull(),
                'full_sem_long' => $this->tinyInteger()->notNull(),
                'full_sem_short' => $this->tinyInteger()->notNull(),
                'part_week_long' => $this->tinyInteger()->notNull(),
                'part_week_short' => $this->tinyInteger()->notNull(),
                'part_sem_long' => $this->tinyInteger()->notNull(),
                'part_sem_short' => $this->tinyInteger()->notNull(),
                'full_time_year' => $this->decimal(2, 1)->notNull(),
                'full_max_year' => $this->decimal(2, 1)->notNull(),
                'part_max_year' => $this->decimal(2, 1)->notNull(),
                'part_time_year' => $this->decimal(2, 1)->notNull(),
                'synopsis' => $this->text()->notNull(),
                'synopsis_bi' => $this->text()->notNull(),
                'objective' => $this->text()->notNull(),
                'just_stat' => $this->text()->notNull(),
                'just_industry' => $this->text()->notNull(),
                'just_employ' => $this->text()->notNull(),
                'just_tech' => $this->text()->notNull(),
                'just_others' => $this->text()->notNull(),
                'nec_perjawatan' => $this->text()->notNull(),
                'nec_fizikal' => $this->text()->notNull(),
                'nec_kewangan' => $this->text()->notNull(),
                'kos_yuran' => $this->text()->notNull(),
                'kos_beven' => $this->text()->notNull(),
                'pro_tindih_pub' => $this->text()->notNull(),
                'pro_tindih_pri' => $this->text()->notNull(),
                'jumud' => $this->text()->notNull(),
                'admission_req' => $this->text()->notNull(),
                'admission_req_bi' => $this->text()->notNull(),
                'career' => $this->text()->notNull(),
                'career_bi' => $this->text()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
                'trash' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('pro_level', '{{%sp_program}}', ['pro_level']);
    }

    public function down()
    {
        $this->dropTable('{{%sp_program}}');
    }
}
