<?php

use yii\db\Migration;

class m201127_085638_0018_create_table_jeb_email_template extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%jeb_email_template}}',
            [
                'id' => $this->primaryKey(),
                'on_enter_workflow' => $this->string(100)->notNull(),
                'target_role' => $this->text()->notNull(),
                'description' => $this->string(200)->notNull(),
                'notification_subject' => $this->string(100)->notNull(),
                'notification' => $this->text()->notNull(),
                'do_reminder' => $this->boolean()->notNull(),
                'reminder_subject' => $this->string(100)->notNull(),
                'reminder' => $this->text()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%jeb_email_template}}');
    }
}
