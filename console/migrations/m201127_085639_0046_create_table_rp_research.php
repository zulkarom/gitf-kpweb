<?php

use yii\db\Migration;

class m201127_085639_0046_create_table_rp_research extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%rp_research}}',
            [
                'id' => $this->primaryKey(),
                'status' => $this->tinyInteger(4)->notNull(),
                'res_title' => $this->string(600)->notNull(),
                'res_staff' => $this->integer()->notNull(),
                'res_progress' => $this->boolean()->notNull()->comment('1=finish,0 = ongoing'),
                'date_start' => $this->date()->notNull(),
                'date_end' => $this->date()->notNull(),
                'res_grant' => $this->integer()->notNull(),
                'res_grant_others' => $this->string(200)->notNull(),
                'res_source' => $this->string(200)->notNull(),
                'sponsor_category' => $this->integer(2)->notNull(),
                'res_amount' => $this->decimal(11, 2)->notNull(),
                'res_file' => $this->text()->notNull(),
                'modified_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'created_at' => $this->dateTime()->notNull(),
                'reminder' => $this->boolean()->notNull(),
                'reviewed_at' => $this->dateTime()->notNull(),
                'reviewed_by' => $this->integer()->notNull(),
                'review_note' => $this->text()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%rp_research}}');
    }
}
