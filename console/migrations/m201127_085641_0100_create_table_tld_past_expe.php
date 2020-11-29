<?php

use yii\db\Migration;

class m201127_085641_0100_create_table_tld_past_expe extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%tld_past_expe}}',
            [
                'id' => $this->primaryKey(),
                'staff_id' => $this->integer()->notNull(),
                'employer' => $this->string(200)->notNull(),
                'position' => $this->string(100)->notNull(),
                'start_end' => $this->string(100)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%tld_past_expe}}');
    }
}
