<?php

use yii\db\Migration;

class m201127_085639_0041_create_table_rp_pub_author extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%rp_pub_author}}',
            [
                'id' => $this->primaryKey(),
                'pub_id' => $this->integer()->notNull(),
                'au_name' => $this->string(500)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%rp_pub_author}}');
    }
}