<?php

use yii\db\Migration;

class m201127_085639_0051_create_table_social_account extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%social_account}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer(),
                'provider' => $this->string()->notNull(),
                'client_id' => $this->string()->notNull(),
                'data' => $this->text(),
                'code' => $this->string(32),
                'created_at' => $this->integer(),
                'email' => $this->string(),
                'username' => $this->string(),
            ],
            $tableOptions
        );

        $this->createIndex('account_unique', '{{%social_account}}', ['provider', 'client_id'], true);
        $this->createIndex('fk_user_account', '{{%social_account}}', ['user_id']);
        $this->createIndex('account_unique_code', '{{%social_account}}', ['code'], true);
    }

    public function down()
    {
        $this->dropTable('{{%social_account}}');
    }
}
