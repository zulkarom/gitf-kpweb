<?php

use yii\db\Migration;

class m201127_085639_0036_create_table_rp_consultation extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%rp_consultation}}',
            [
                'id' => $this->primaryKey(),
                'csl_staff' => $this->integer()->notNull(),
                'csl_title' => $this->string(500)->notNull(),
                'csl_funder' => $this->string(500)->notNull(),
                'csl_amount' => $this->decimal(11, 2),
                'csl_level' => $this->boolean()->notNull()->comment('1=local,2=international'),
                'date_start' => $this->date()->notNull(),
                'date_end' => $this->date()->notNull(),
                'csl_file' => $this->text()->notNull(),
                'status' => $this->integer()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'modified_at' => $this->dateTime()->notNull(),
                'reviewed_by' => $this->integer()->notNull(),
                'reviewed_at' => $this->dateTime()->notNull(),
                'review_note' => $this->text()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%rp_consultation}}');
    }
}
