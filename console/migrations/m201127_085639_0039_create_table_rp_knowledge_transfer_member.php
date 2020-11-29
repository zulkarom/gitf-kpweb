<?php

use yii\db\Migration;

class m201127_085639_0039_create_table_rp_knowledge_transfer_member extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%rp_knowledge_transfer_member}}',
            [
                'id' => $this->primaryKey(),
                'ktp_id' => $this->integer()->notNull(),
                'staff_id' => $this->integer(),
                'ext_name' => $this->string(200)->notNull(),
                'ktp_order' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%rp_knowledge_transfer_member}}');
    }
}
