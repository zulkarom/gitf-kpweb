<?php

use yii\db\Migration;

class m201127_085638_0032_create_table_qb_question_option extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%qb_question_option}}',
            [
                'id' => $this->primaryKey(),
                'question_id' => $this->integer()->notNull(),
                'option_text' => $this->string(200)->notNull(),
                'option_text_bi' => $this->string(200)->notNull(),
                'is_answer' => $this->boolean()->notNull(),
                'option_order' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%qb_question_option}}');
    }
}
