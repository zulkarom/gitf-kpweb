<?php

use yii\db\Migration;

class m201127_085641_0107_create_table_token extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%token}}',
            [
                'user_id' => $this->integer()->notNull(),
                'code' => $this->string(32)->notNull(),
                'created_at' => $this->integer()->notNull(),
                'type' => $this->smallInteger()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('token_unique', '{{%token}}', ['user_id', 'code', 'type'], true);
    }

    public function down()
    {
        $this->dropTable('{{%token}}');
    }
}
