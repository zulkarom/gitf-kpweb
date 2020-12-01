<?php

use yii\db\Migration;

class m201127_085640_0080_create_table_sp_study_mode extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_study_mode}}',
            [
                'id' => $this->primaryKey(),
                'mode_name' => $this->string(50)->notNull(),
                'mode_name_bi' => $this->string(100)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_study_mode}}');
    }
}
