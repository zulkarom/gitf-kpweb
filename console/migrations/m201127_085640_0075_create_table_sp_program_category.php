<?php

use yii\db\Migration;

class m201127_085640_0075_create_table_sp_program_category extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_program_category}}',
            [
                'id' => $this->primaryKey(),
                'cat_name' => $this->string(250)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_program_category}}');
    }
}
