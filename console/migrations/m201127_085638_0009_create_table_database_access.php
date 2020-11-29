<?php

use yii\db\Migration;

class m201127_085638_0009_create_table_database_access extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%database_access}}',
            [
                'acc_id' => $this->primaryKey(),
                'db_id' => $this->integer()->notNull(),
                'staff_id' => $this->integer()->notNull(),
                'access_read' => $this->boolean()->notNull(),
                'access_write' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%database_access}}');
    }
}
