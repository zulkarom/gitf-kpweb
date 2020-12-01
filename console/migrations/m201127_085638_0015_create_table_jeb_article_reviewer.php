<?php

use yii\db\Migration;

class m201127_085638_0015_create_table_jeb_article_reviewer extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%jeb_article_reviewer}}',
            [
                'id' => $this->primaryKey(),
                'article_id' => $this->integer()->notNull(),
                'scope_id' => $this->integer()->notNull(),
                'user_id' => $this->integer()->notNull(),
                'status' => $this->boolean()->notNull()->comment('0 => \'Appoint\', 10 => \'Review In Progress\', 20 => \'Completed\', 30 => \'Reject\', 40 => \'Canceled\', 50 => \'Error\''),
                'q_1' => $this->boolean()->notNull(),
                'q_2' => $this->boolean()->notNull(),
                'q_3' => $this->boolean()->notNull(),
                'q_4' => $this->boolean()->notNull(),
                'q_5' => $this->boolean()->notNull(),
                'q_6' => $this->boolean()->notNull(),
                'q_7' => $this->boolean()->notNull(),
                'q_8' => $this->boolean()->notNull(),
                'q_9' => $this->boolean()->notNull(),
                'q_10' => $this->boolean()->notNull(),
                'q_11' => $this->boolean()->notNull(),
                'review_option' => $this->boolean()->notNull(),
                'review_note' => $this->text()->notNull(),
                'reviewed_file' => $this->string(200)->notNull(),
                'review_at' => $this->dateTime()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'completed_at' => $this->dateTime()->notNull(),
                'cancel_at' => $this->dateTime()->notNull(),
                'reject_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%jeb_article_reviewer}}');
    }
}
