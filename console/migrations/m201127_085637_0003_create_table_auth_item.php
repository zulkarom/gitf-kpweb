<?php

use yii\db\Migration;

class m201127_085637_0003_create_table_auth_item extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%auth_item}}',
            [
                'name' => $this->string(64)->notNull()->append('PRIMARY KEY'),
                'type' => $this->integer()->notNull(),
                'description' => $this->text(),
                'rule_name' => $this->string(64),
                'data' => $this->text(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ],
            $tableOptions
        );

        $this->createIndex('rule_name', '{{%auth_item}}', ['rule_name']);
        $this->createIndex('type', '{{%auth_item}}', ['type']);
    }

    public function down()
    {
        $this->dropTable('{{%auth_item}}');
    }
}
