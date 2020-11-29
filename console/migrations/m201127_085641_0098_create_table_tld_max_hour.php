<?php

use yii\db\Migration;

class m201127_085641_0098_create_table_tld_max_hour extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%tld_max_hour}}',
            [
                'id' => $this->primaryKey(),
                'staff_id' => $this->integer()->notNull(),
                'max_hour' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%tld_max_hour}}');
    }
}
