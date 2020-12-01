<?php

use yii\db\Migration;

class m201127_085639_0045_create_table_rp_publication extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%rp_publication}}',
            [
                'id' => $this->primaryKey(),
                'staff_id' => $this->integer()->notNull(),
                'status' => $this->tinyInteger(4)->notNull(),
                'pub_type' => $this->integer()->notNull(),
                'pub_year' => $this->integer()->notNull(),
                'pub_title' => $this->string(500)->notNull(),
                'pub_journal' => $this->string(500)->notNull(),
                'pub_volume' => $this->string(100)->notNull(),
                'pub_issue' => $this->string(100)->notNull(),
                'pub_page' => $this->string(500)->notNull(),
                'pub_city' => $this->string(500)->notNull(),
                'pub_state' => $this->string(500)->notNull(),
                'pub_publisher' => $this->string(500)->notNull(),
                'pub_isbn' => $this->string(200)->notNull(),
                'pub_organizer' => $this->string(200)->notNull(),
                'pub_inbook' => $this->string(500)->notNull(),
                'pub_month' => $this->string(500)->notNull(),
                'pub_day' => $this->string(100)->notNull(),
                'pub_date' => $this->string(100)->notNull(),
                'pub_index' => $this->string(200)->notNull(),
                'has_file' => $this->boolean()->notNull(),
                'pubupload_file' => $this->text()->notNull(),
                'pubother_file' => $this->text()->notNull(),
                'modified_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'created_at' => $this->dateTime()->notNull(),
                'reviewed_at' => $this->dateTime()->notNull(),
                'reviewed_by' => $this->integer()->notNull(),
                'review_note' => $this->text()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%rp_publication}}');
    }
}
