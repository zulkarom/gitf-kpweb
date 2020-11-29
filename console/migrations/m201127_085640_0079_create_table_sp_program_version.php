<?php

use yii\db\Migration;

class m201127_085640_0079_create_table_sp_program_version extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_program_version}}',
            [
                'id' => $this->primaryKey(),
                'program_id' => $this->integer()->notNull(),
                'version_name' => $this->string(200)->notNull(),
                'status' => $this->tinyInteger(4)->notNull(),
                'version_type_id' => $this->integer()->notNull(),
                'is_developed' => $this->boolean()->notNull(),
                'is_published' => $this->boolean()->notNull(),
                'trash' => $this->boolean()->notNull(),
                'created_by' => $this->integer()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
                'prepared_by' => $this->integer()->notNull(),
                'prepared_at' => $this->date()->notNull(),
                'verified_by' => $this->integer()->notNull(),
                'verified_at' => $this->date()->notNull(),
                'faculty_approve_at' => $this->date()->notNull(),
                'senate_approve_at' => $this->date()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_program_version}}');
    }
}
