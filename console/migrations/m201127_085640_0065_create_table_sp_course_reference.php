<?php

use yii\db\Migration;

class m201127_085640_0065_create_table_sp_course_reference extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_reference}}',
            [
                'id' => $this->primaryKey(),
                'crs_version_id' => $this->integer()->notNull(),
                'ref_full' => $this->text()->notNull(),
                'ref_year' => $this->date()->notNull(),
                'is_classic' => $this->boolean()->notNull(),
                'is_main' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_reference}}');
    }
}
