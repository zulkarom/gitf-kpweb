<?php

use yii\db\Migration;

class m201127_085638_0019_create_table_jeb_journal extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%jeb_journal}}',
            [
                'id' => $this->primaryKey(),
                'journal_name' => $this->string(200)->notNull(),
                'volume' => $this->integer()->notNull(),
                'issue' => $this->integer()->notNull(),
                'status' => $this->integer()->notNull(),
                'description' => $this->text()->notNull(),
                'published_at' => $this->date()->notNull(),
                'archived_at' => $this->dateTime()->notNull(),
                'is_special' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%jeb_journal}}');
    }
}
