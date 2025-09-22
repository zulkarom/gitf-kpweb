<?php
use yii\db\Migration;

class m250922_045500_add_user_id_to_st_student extends Migration
{
    public function safeUp()
    {
        // add column if not exists
        $table = $this->db->schema->getTableSchema('st_student', true);
        if (!isset($table->columns['user_id'])) {
            $this->addColumn('st_student', 'user_id', $this->integer()->null()->after('program'));
        }
        // add index and FK if not exists
        $indexes = $this->db->createCommand("SHOW INDEX FROM st_student WHERE Key_name='idx-st_student-user_id'")->queryAll();
        if (empty($indexes)) {
            $this->createIndex('idx-st_student-user_id', 'st_student', 'user_id');
        }
        // ensure user table exists before adding FK
        $userTable = $this->db->schema->getTableSchema('{{%user}}', true);
        if ($userTable) {
            // drop existing FK if exists to avoid duplicate
            try {
                $this->dropForeignKey('fk-st_student-user_id', 'st_student');
            } catch (\Throwable $e) {}
            $this->addForeignKey('fk-st_student-user_id', 'st_student', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        }
    }

    public function safeDown()
    {
        try {
            $this->dropForeignKey('fk-st_student-user_id', 'st_student');
        } catch (\Throwable $e) {}
        try {
            $this->dropIndex('idx-st_student-user_id', 'st_student');
        } catch (\Throwable $e) {}
        $table = $this->db->schema->getTableSchema('st_student', true);
        if (isset($table->columns['user_id'])) {
            $this->dropColumn('st_student', 'user_id');
        }
    }
}
