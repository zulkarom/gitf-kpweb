<?php

use yii\db\Migration;

class m201127_085638_0030_create_table_qb_question extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%qb_question}}',
            [
                'id' => $this->primaryKey(),
                'course_id' => $this->integer()->notNull(),
                'qtype_id' => $this->integer()->notNull(),
                'qtext' => $this->text()->notNull(),
                'qtext_bi' => $this->text()->notNull(),
                'category_id' => $this->integer()->notNull(),
                'level' => $this->boolean()->notNull()->comment('1=easy, 2 = medium, 3 = hard'),
                'created_at' => $this->dateTime()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%qb_question}}');
    }
}
