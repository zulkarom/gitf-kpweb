<?php

use yii\db\Migration;

class m201127_085638_0022_create_table_jeb_user_scope extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%jeb_user_scope}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'scope_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%jeb_user_scope}}');
    }
}
