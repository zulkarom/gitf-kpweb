<?php

use yii\db\Migration;

class m201127_085638_0031_create_table_qb_question_cat extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%qb_question_cat}}',
            [
                'id' => $this->primaryKey(),
                'course_id' => $this->integer()->notNull(),
                'cat_text' => $this->string(200)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%qb_question_cat}}');
    }
}
