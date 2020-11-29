<?php

use yii\db\Migration;

class m201127_085639_0040_create_table_rp_membership extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%rp_membership}}',
            [
                'id' => $this->primaryKey(),
                'msp_staff' => $this->integer()->notNull(),
                'msp_body' => $this->string(500)->notNull(),
                'msp_type' => $this->string(500)->notNull(),
                'msp_level' => $this->boolean()->notNull()->comment('1=local,2=international'),
                'date_start' => $this->date()->notNull(),
                'date_end' => $this->date()->notNull(),
                'msp_file' => $this->string(100)->notNull(),
                'status' => $this->integer()->notNull(),
                'reviewed_by' => $this->integer()->notNull(),
                'reviewed_at' => $this->dateTime()->notNull(),
                'review_note' => $this->text()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'modified_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%rp_membership}}');
    }
}
