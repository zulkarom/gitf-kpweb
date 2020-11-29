<?php

use yii\db\Migration;

class m201127_085641_0110_create_table_users extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%users}}',
            [
                'user_id' => $this->primaryKey()->comment('auto incrementing user_id of each user, unique index'),
                'user_name' => $this->string(64)->notNull()->comment('user\'s name, unique'),
                'user_password_hash' => $this->string()->notNull()->comment('user\'s password in salted and hashed format'),
                'user_email' => $this->string(64)->notNull()->comment('user\'s email, unique'),
            ],
            $tableOptions
        );

        $this->createIndex('user_name', '{{%users}}', ['user_name'], true);
        $this->createIndex('user_email', '{{%users}}', ['user_email'], true);
    }

    public function down()
    {
        $this->dropTable('{{%users}}');
    }
}
