<?php

use yii\db\Migration;

class m201127_085641_0094_create_table_testing extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%testing}}',
            [
                'saya_awak' => $this->integer()->notNull(),
                'wer' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%testing}}');
    }
}
