<?php

use yii\db\Migration;

class m201127_085638_0026_create_table_proc_paper extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%proc_paper}}',
            [
                'id' => $this->primaryKey(),
                'proc_id' => $this->integer()->notNull(),
                'paper_title' => $this->string()->notNull(),
                'author' => $this->string()->notNull(),
                'paper_no' => $this->integer()->notNull(),
                'paper_page' => $this->string(100)->notNull(),
                'paper_file' => $this->text()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%proc_paper}}');
    }
}
