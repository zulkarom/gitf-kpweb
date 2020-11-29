<?php

use yii\db\Migration;

class m201127_085638_0012_create_table_faculty extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%faculty}}',
            [
                'id' => $this->primaryKey(),
                'faculty_name' => $this->string(200)->notNull(),
                'faculty_name_bi' => $this->string(250)->notNull(),
                'not_academic' => $this->boolean()->notNull(),
                'scode' => $this->string(10)->notNull(),
                'syncing' => $this->boolean()->notNull()->defaultValue('1'),
                'showing' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%faculty}}');
    }
}
