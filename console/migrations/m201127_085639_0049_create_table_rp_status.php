<?php

use yii\db\Migration;

class m201127_085639_0049_create_table_rp_status extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%rp_status}}',
            [
                'id' => $this->primaryKey(),
                'status_code' => $this->integer()->notNull(),
                'status_name' => $this->string(50)->notNull(),
                'status_color' => $this->string(50)->notNull(),
                'admin_show' => $this->boolean()->notNull(),
                'admin_action' => $this->boolean()->notNull(),
                'user_show' => $this->boolean()->notNull(),
                'user_edit' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%rp_status}}');
    }
}
