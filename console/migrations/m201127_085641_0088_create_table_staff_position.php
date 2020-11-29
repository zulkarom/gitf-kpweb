<?php

use yii\db\Migration;

class m201127_085641_0088_create_table_staff_position extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%staff_position}}',
            [
                'id' => $this->primaryKey(),
                'position_name' => $this->string(46),
                'position_gred' => $this->string(4),
                'position_order' => $this->decimal(3, 1)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%staff_position}}');
    }
}
