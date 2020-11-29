<?php

use yii\db\Migration;

class m201127_085638_0034_create_table_rp_award extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%rp_award}}',
            [
                'id' => $this->primaryKey(),
                'awd_staff' => $this->integer()->notNull(),
                'status' => $this->integer()->notNull(),
                'awd_name' => $this->string(300)->notNull(),
                'awd_level' => $this->boolean()->notNull(),
                'awd_type' => $this->string(100)->notNull(),
                'awd_by' => $this->string(300)->notNull(),
                'awd_date' => $this->date()->notNull(),
                'awd_file' => $this->text()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'modified_at' => $this->dateTime()->notNull(),
                'reviewed_at' => $this->dateTime()->notNull(),
                'reviewed_by' => $this->integer()->notNull(),
                'review_note' => $this->text()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%rp_award}}');
    }
}
