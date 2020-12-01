<?php

use yii\db\Migration;

class m201127_085639_0038_create_table_rp_knowledge_transfer extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%rp_knowledge_transfer}}',
            [
                'id' => $this->primaryKey(),
                'ktp_title' => $this->string(600)->notNull(),
                'staff_id' => $this->integer()->notNull(),
                'date_start' => $this->date()->notNull(),
                'date_end' => $this->date()->notNull(),
                'ktp_research' => $this->string(200)->notNull(),
                'ktp_community' => $this->string(200)->notNull(),
                'ktp_source' => $this->string(200)->notNull(),
                'ktp_amount' => $this->decimal(11, 2)->notNull(),
                'ktp_description' => $this->text()->notNull(),
                'ktp_file' => $this->string(200)->notNull(),
                'modified_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'status' => $this->integer()->notNull(),
                'reviewed_by' => $this->integer()->notNull(),
                'reviewed_at' => $this->dateTime()->notNull(),
                'review_note' => $this->text()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'reminder' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%rp_knowledge_transfer}}');
    }
}
