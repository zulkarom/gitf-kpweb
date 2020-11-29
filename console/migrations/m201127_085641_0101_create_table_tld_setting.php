<?php

use yii\db\Migration;

class m201127_085641_0101_create_table_tld_setting extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%tld_setting}}',
            [
                'id' => $this->primaryKey(),
                'date_start' => $this->date()->notNull(),
                'date_end' => $this->date()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
                'updated_by' => $this->integer()->notNull(),
                'max_hour' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%tld_setting}}');
    }
}
