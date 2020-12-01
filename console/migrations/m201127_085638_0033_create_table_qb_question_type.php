<?php

use yii\db\Migration;

class m201127_085638_0033_create_table_qb_question_type extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%qb_question_type}}',
            [
                'id' => $this->primaryKey(),
                'code' => $this->string(20)->notNull(),
                'code_text' => $this->string(200)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%qb_question_type}}');
    }
}
