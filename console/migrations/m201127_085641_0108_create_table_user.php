<?php

use yii\db\Migration;

class m201127_085641_0108_create_table_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%user}}',
            [
                'id' => $this->primaryKey(),
                'username' => $this->string()->notNull(),
                'fullname' => $this->string(200)->notNull(),
                'email' => $this->string()->notNull(),
                'auth_key' => $this->string(32)->notNull(),
                'confirmed_at' => $this->integer(),
                'unconfirmed_email' => $this->string()->notNull(),
                'blocked_at' => $this->integer()->notNull(),
                'registration_ip' => $this->string(45)->notNull(),
                'flags' => $this->integer()->notNull(),
                'last_login_at' => $this->integer()->notNull(),
                'password_hash' => $this->string()->notNull(),
                'status' => $this->smallInteger()->notNull()->defaultValue('10'),
                'password_reset_token' => $this->string(),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
                'user_image' => $this->string(100)->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('username', '{{%user}}', ['username'], true);
        $this->createIndex('password_reset_token', '{{%user}}', ['password_reset_token'], true);
        $this->createIndex('email', '{{%user}}', ['email'], true);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
