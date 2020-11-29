<?php

use yii\db\Migration;

class m201127_085639_0059_create_table_sp_course_clo_assess extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_clo_assess}}',
            [
                'id' => $this->primaryKey(),
                'clo_id' => $this->integer()->notNull(),
                'assess_id' => $this->integer()->notNull(),
                'percentage' => $this->integer(3)->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('clo_id', '{{%sp_course_clo_assess}}', ['clo_id']);
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_clo_assess}}');
    }
}
