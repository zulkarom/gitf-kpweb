<?php

use yii\db\Migration;

class m201127_085641_0112_create_table_web_front_slider extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%web_front_slider}}',
            [
                'id' => $this->primaryKey(),
                'slide_name' => $this->string(100)->notNull(),
                'image_file' => $this->text()->notNull(),
                'slide_url' => $this->string(200)->notNull(),
                'caption' => $this->text()->notNull(),
                'slide_order' => $this->integer()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
                'created_by' => $this->integer()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'is_publish' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%web_front_slider}}');
    }
}
