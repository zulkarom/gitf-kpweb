<?php

use yii\db\Migration;

class m201127_085641_0090_create_table_staff_position_type extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%staff_position_type}}',
            [
                'pos_id' => $this->primaryKey(),
                'pos_name_bm' => $this->string(250)->notNull(),
                'pos_name_bi' => $this->string(250)->notNull(),
                'pos_order' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%staff_position_type}}');
    }
}
