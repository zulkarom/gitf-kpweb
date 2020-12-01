<?php

use yii\db\Migration;

class m201127_085641_0097_create_table_tld_lec_lecturer extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%tld_lec_lecturer}}',
            [
                'id' => $this->primaryKey(),
                'lecture_id' => $this->integer()->notNull(),
                'staff_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%tld_lec_lecturer}}');
    }
}
