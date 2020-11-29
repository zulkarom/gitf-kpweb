<?php

use yii\db\Migration;

class m201127_085641_0111_create_table_web_event extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%web_event}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(200)->notNull(),
                'date_start' => $this->date()->notNull(),
                'date_end' => $this->date()->notNull(),
                'time_start' => $this->time()->notNull(),
                'time_end' => $this->time()->notNull(),
                'city' => $this->string(100)->notNull(),
                'venue' => $this->string(200)->notNull(),
                'register_link' => $this->text()->notNull(),
                'intro_promo' => $this->text()->notNull(),
                'promoimg_file' => $this->text()->notNull(),
                'newsimg_file' => $this->text()->notNull(),
                'report_1' => $this->text()->notNull(),
                'report_2' => $this->text()->notNull(),
                'imagetop_file' => $this->text()->notNull(),
                'imagemiddle_file' => $this->text()->notNull(),
                'imagebottom_file' => $this->text()->notNull(),
                'publish_promo' => $this->boolean()->notNull(),
                'publish_report' => $this->boolean()->notNull(),
                'created_by' => $this->integer()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'target_participant' => $this->text()->notNull(),
                'fee' => $this->decimal(11, 2)->notNull(),
                'objective' => $this->text()->notNull(),
                'register_deadline' => $this->date()->notNull(),
                'contact_pic' => $this->text()->notNull(),
                'brochure_file' => $this->text()->notNull(),
                'speaker' => $this->text()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%web_event}}');
    }
}
