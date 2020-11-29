<?php

use yii\db\Migration;

class m201127_085641_0106_create_table_tld_tutorial_tutor extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%tld_tutorial_tutor}}',
            [
                'id' => $this->primaryKey(),
                'tutorial_id' => $this->integer()->notNull(),
                'staff_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%tld_tutorial_tutor}}');
    }
}
