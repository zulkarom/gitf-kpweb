<?php

use yii\db\Migration;

class m201127_085640_0078_create_table_sp_program_structure extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_program_structure}}',
            [
                'id' => $this->primaryKey(),
                'prg_version_id' => $this->integer()->notNull(),
                'crs_version_id' => $this->integer()->notNull(),
                'course_type_id' => $this->integer()->notNull(),
                'sem_num' => $this->boolean()->notNull()->comment('e.g. 1 or 2 = semester 1, semester dua'),
                'year' => $this->tinyInteger(2)->notNull(),
                'sem_num_part' => $this->boolean()->notNull(),
                'year_part' => $this->tinyInteger(2)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_program_structure}}');
    }
}
