<?php

use yii\db\Migration;

class m201127_085641_0104_create_table_tld_tgt_course extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%tld_tgt_course}}',
            [
                'id' => $this->primaryKey(),
                'staff_id' => $this->integer()->notNull(),
                'course_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%tld_tgt_course}}');
    }
}
