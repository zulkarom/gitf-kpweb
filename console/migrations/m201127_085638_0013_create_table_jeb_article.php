<?php

use yii\db\Migration;

class m201127_085638_0013_create_table_jeb_article extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%jeb_article}}',
            [
                'id' => $this->primaryKey(),
                'manuscript_no' => $this->string(200)->notNull(),
                'user_id' => $this->integer()->notNull(),
                'title' => $this->text()->notNull(),
                'title_sc' => $this->text()->notNull(),
                'keyword' => $this->text()->notNull(),
                'abstract' => $this->text()->notNull(),
                'reference' => $this->text()->notNull(),
                'scope_id' => $this->tinyInteger(2)->notNull(),
                'status' => $this->string(100)->notNull(),
                'submission_file' => $this->string(200)->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
                'draft_at' => $this->dateTime()->notNull(),
                'submit_at' => $this->dateTime()->notNull(),
                'pre_evaluate_at' => $this->dateTime()->notNull(),
                'pre_evaluate_by' => $this->integer()->notNull(),
                'associate_editor' => $this->integer()->notNull(),
                'review_file' => $this->string(200)->notNull(),
                'pre_evaluate_note' => $this->text()->notNull(),
                'asgn_reviewer_at' => $this->dateTime()->notNull(),
                'asgn_reviewer_by' => $this->integer()->notNull(),
                'review_at' => $this->dateTime()->notNull(),
                'recommend_by' => $this->integer()->notNull(),
                'recommend_at' => $this->dateTime()->notNull(),
                'recommend_note' => $this->text()->notNull(),
                'recommend_option' => $this->boolean()->notNull(),
                'evaluate_option' => $this->boolean()->notNull(),
                'evaluate_note' => $this->text()->notNull(),
                'evaluate_by' => $this->integer()->notNull(),
                'evaluate_at' => $this->dateTime()->notNull(),
                'response_by' => $this->integer()->notNull(),
                'response_at' => $this->dateTime()->notNull(),
                'response_note' => $this->text()->notNull(),
                'correction_at' => $this->dateTime()->notNull(),
                'correction_note' => $this->text()->notNull(),
                'correction_file' => $this->string(100)->notNull(),
                'post_evaluate_by' => $this->integer()->notNull(),
                'post_evaluate_at' => $this->dateTime()->notNull(),
                'assistant_editor' => $this->integer()->notNull(),
                'galley_proof_at' => $this->dateTime()->notNull(),
                'galley_proof_by' => $this->integer()->notNull(),
                'galley_proof_note' => $this->text()->notNull(),
                'galley_file' => $this->string(200)->notNull(),
                'finalise_at' => $this->dateTime()->notNull(),
                'finalise_option' => $this->boolean()->notNull(),
                'finalise_note' => $this->text()->notNull(),
                'finalise_file' => $this->string(200)->notNull(),
                'asgn_profrdr_at' => $this->dateTime()->notNull(),
                'asgn_profrdr_by' => $this->integer()->notNull(),
                'asgn_profrdr_note' => $this->text()->notNull(),
                'proof_reader' => $this->integer()->notNull(),
                'post_finalise_at' => $this->dateTime()->notNull(),
                'post_finalise_by' => $this->integer()->notNull(),
                'postfinalise_file' => $this->string(200)->notNull(),
                'post_finalise_note' => $this->text()->notNull(),
                'proofread_at' => $this->dateTime()->notNull(),
                'proofread_by' => $this->integer()->notNull(),
                'proofread_note' => $this->text()->notNull(),
                'proofread_file' => $this->string(200)->notNull(),
                'camera_ready_at' => $this->dateTime()->notNull(),
                'camera_ready_by' => $this->integer()->notNull(),
                'camera_ready_note' => $this->text()->notNull(),
                'cameraready_file' => $this->string(200)->notNull(),
                'assign_journal_at' => $this->dateTime()->notNull(),
                'journal_at' => $this->dateTime()->notNull(),
                'journal_by' => $this->integer()->notNull(),
                'journal_id' => $this->integer()->notNull(),
                'reject_at' => $this->dateTime()->notNull(),
                'reject_by' => $this->integer()->notNull(),
                'reject_note' => $this->text()->notNull(),
                'publish_number' => $this->string(10)->notNull(),
                'withdraw_by' => $this->integer()->notNull(),
                'withdraw_at_status' => $this->string(100)->notNull(),
                'withdraw_note' => $this->text()->notNull(),
                'withdraw_at' => $this->dateTime()->notNull(),
                'withdraw_request_at' => $this->dateTime()->notNull(),
                'page_from' => $this->integer()->notNull(),
                'page_to' => $this->integer()->notNull(),
                'doi_ref' => $this->string(200)->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('manuscript_no', '{{%jeb_article}}', ['manuscript_no'], true);
    }

    public function down()
    {
        $this->dropTable('{{%jeb_article}}');
    }
}
