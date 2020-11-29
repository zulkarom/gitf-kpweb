<?php

use yii\db\Migration;

class m201127_085639_0050_create_table_semester extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%semester}}',
            [
                'id' => $this->primaryKey(),
                'description' => $this->text()->notNull(),
                'is_current' => $this->boolean()->notNull(),
                'is_open' => $this->boolean()->notNull(),
                'date_start' => $this->date()->notNull(),
                'date_end' => $this->date()->notNull(),
                'open_at' => $this->date()->notNull(),
                'close_at' => $this->date()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'created_by' => $this->integer()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
                'result_date' => $this->date()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%semester}}');
    }
}
