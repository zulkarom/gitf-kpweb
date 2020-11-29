<?php

use yii\db\Migration;

class m201127_085639_0043_create_table_rp_pub_tag extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%rp_pub_tag}}',
            [
                'id' => $this->primaryKey(),
                'pub_id' => $this->integer()->notNull(),
                'staff_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%rp_pub_tag}}');
    }
}
