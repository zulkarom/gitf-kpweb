<?php

use yii\db\Migration;

class m201127_085640_0069_create_table_sp_course_transfer extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_transfer}}',
            [
                'id' => $this->primaryKey(),
                'crs_version_id' => $this->integer()->notNull(),
                'transferable_id' => $this->integer()->notNull(),
                'transfer_order' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_transfer}}');
    }
}
