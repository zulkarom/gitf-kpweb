<?php

use yii\db\Migration;

class m201127_085638_0028_create_table_profile extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%profile}}',
            [
                'user_id' => $this->primaryKey(),
                'name' => $this->string(),
                'public_email' => $this->string(),
                'gravatar_email' => $this->string(),
                'gravatar_id' => $this->string(32),
                'location' => $this->string(),
                'website' => $this->string(),
                'bio' => $this->text(),
                'timezone' => $this->string(40),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%profile}}');
    }
}
