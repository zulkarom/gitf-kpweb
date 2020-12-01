<?php

use yii\db\Migration;

class m201127_085639_0060_create_table_sp_course_clo_delivery extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_clo_delivery}}',
            [
                'id' => $this->primaryKey(),
                'clo_id' => $this->integer()->notNull(),
                'delivery_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('clo_id', '{{%sp_course_clo_delivery}}', ['clo_id']);
        $this->createIndex('delivery_id', '{{%sp_course_clo_delivery}}', ['delivery_id']);
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_clo_delivery}}');
    }
}
