<?php

use yii\db\Migration;

class m201127_085639_0056_create_table_sp_course_assessment extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_assessment}}',
            [
                'id' => $this->primaryKey(),
                'crs_version_id' => $this->integer()->notNull(),
                'assess_name' => $this->string(100)->notNull(),
                'assess_name_bi' => $this->string(100)->notNull(),
                'assess_cat' => $this->integer()->notNull(),
                'assess_f2f' => $this->double()->notNull(),
                'assess_f2f_tech' => $this->double()->notNull(),
                'assess_nf2f' => $this->double()->notNull(),
                'trash' => $this->boolean()->notNull(),
                'created_by' => $this->integer()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_assessment}}');
    }
}
