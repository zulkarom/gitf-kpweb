<?php

use yii\db\Migration;

class m201127_085642_0113_create_table_web_program extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%web_program}}',
            [
                'id' => $this->primaryKey(),
                'program_id' => $this->integer()->notNull(),
                'summary' => $this->text()->notNull(),
                'career' => $this->text()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('program_id', '{{%web_program}}', ['program_id']);
    }

    public function down()
    {
        $this->dropTable('{{%web_program}}');
    }
}
