<?php

use yii\db\Migration;

class m201127_085638_0011_create_table_department extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%department}}',
            [
                'id' => $this->primaryKey(),
                'dep_name' => $this->string(200)->notNull(),
                'dep_name_bi' => $this->string(200)->notNull(),
                'faculty' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%department}}');
    }
}
