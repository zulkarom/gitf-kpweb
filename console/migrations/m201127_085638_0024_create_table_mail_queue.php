<?php

use yii\db\Migration;

class m201127_085638_0024_create_table_mail_queue extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%mail_queue}}',
            [
                'id' => $this->primaryKey(),
                'subject' => $this->string(),
                'created_at' => $this->dateTime()->notNull(),
                'attempts' => $this->integer(),
                'last_attempt_time' => $this->dateTime(),
                'sent_time' => $this->dateTime(),
                'time_to_send' => $this->dateTime()->notNull(),
                'swift_message' => $this->text(),
            ],
            $tableOptions
        );

        $this->createIndex('IX_time_to_send', '{{%mail_queue}}', ['time_to_send']);
        $this->createIndex('IX_sent_time', '{{%mail_queue}}', ['sent_time']);
    }

    public function down()
    {
        $this->dropTable('{{%mail_queue}}');
    }
}
