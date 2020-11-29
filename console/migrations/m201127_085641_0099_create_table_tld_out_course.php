<?php

use yii\db\Migration;

class m201127_085641_0099_create_table_tld_out_course extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%tld_out_course}}',
            [
                'id' => $this->primaryKey(),
                'staff_id' => $this->integer()->notNull(),
                'course_name' => $this->string(200)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%tld_out_course}}');
    }
}
