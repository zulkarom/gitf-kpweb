<?php

use yii\db\Migration;

class m201127_085641_0091_create_table_staff_reg_course extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%staff_reg_course}}',
            [
                'stf_reg_id' => $this->primaryKey(255),
                'staff_id' => $this->string(50)->notNull(),
                'course_offer_id' => $this->integer(255)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%staff_reg_course}}');
    }
}
