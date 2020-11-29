<?php

use yii\db\Migration;

class m201127_085638_0014_create_table_jeb_article_author extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%jeb_article_author}}',
            [
                'id' => $this->primaryKey(),
                'article_id' => $this->integer()->notNull(),
                'firstname' => $this->string(200)->notNull(),
                'lastname' => $this->string(200)->notNull(),
                'email' => $this->string()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%jeb_article_author}}');
    }
}
