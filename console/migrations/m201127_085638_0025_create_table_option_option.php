<?php

use yii\db\Migration;

class m201127_085638_0025_create_table_option_option extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%option_option}}',
            [
                'ooption_id' => $this->primaryKey(),
                'option_id' => $this->integer()->notNull(),
                'ooption_text' => $this->string(200)->notNull(),
                'ooption_value' => $this->integer(4)->notNull(),
                'ooption_order' => $this->integer(4)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%option_option}}');
    }
}
