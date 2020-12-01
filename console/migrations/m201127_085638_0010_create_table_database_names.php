<?php

use yii\db\Migration;

class m201127_085638_0010_create_table_database_names extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%database_names}}',
            [
                'db_id' => $this->primaryKey(),
                'identifier' => $this->string(100)->notNull(),
                'db_name' => $this->string()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%database_names}}');
    }
}
