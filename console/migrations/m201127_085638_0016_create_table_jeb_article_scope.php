<?php

use yii\db\Migration;

class m201127_085638_0016_create_table_jeb_article_scope extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%jeb_article_scope}}',
            [
                'id' => $this->primaryKey(),
                'scope_name' => $this->string(200)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%jeb_article_scope}}');
    }
}
