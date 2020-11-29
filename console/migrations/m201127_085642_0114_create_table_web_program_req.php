<?php

use yii\db\Migration;

class m201127_085642_0114_create_table_web_program_req extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%web_program_req}}',
            [
                'id' => $this->primaryKey(),
                'program_id' => $this->integer()->notNull(),
                'req_type' => $this->integer()->notNull()->comment('1=stpm, 2=matric, 3=stam,4=dip'),
                'req_text' => $this->text()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
                'req_order' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('program_id', '{{%web_program_req}}', ['program_id']);
    }

    public function down()
    {
        $this->dropTable('{{%web_program_req}}');
    }
}
