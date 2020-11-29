<?php

use yii\db\Migration;

class m201127_085640_0064_create_table_sp_course_profile extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_profile}}',
            [
                'id' => $this->primaryKey(),
                'crs_version_id' => $this->integer()->notNull(),
                'prerequisite' => $this->integer()->notNull(),
                'offer_sem' => $this->boolean()->notNull(),
                'offer_year' => $this->tinyInteger(2)->notNull(),
                'offer_remark' => $this->string()->notNull(),
                'synopsis' => $this->text()->notNull(),
                'synopsis_bi' => $this->text()->notNull(),
                'transfer_skill' => $this->text()->notNull(),
                'transfer_skill_bi' => $this->text()->notNull(),
                'feedback' => $this->text()->notNull(),
                'feedback_bi' => $this->text()->notNull(),
                'staff_academic' => $this->text()->notNull(),
                'requirement' => $this->text()->notNull(),
                'additional' => $this->text()->notNull(),
                'requirement_bi' => $this->text()->notNull(),
                'additional_bi' => $this->text()->notNull(),
                'offer_at' => $this->string(200)->notNull(),
                'objective' => $this->text()->notNull(),
                'objective_bi' => $this->text()->notNull(),
                'rational' => $this->text()->notNull(),
                'rational_bi' => $this->text()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('crs_version_id', '{{%sp_course_profile}}', ['crs_version_id']);
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_profile}}');
    }
}
