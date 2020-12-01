<?php

use yii\db\Migration;

class m201127_085638_0027_create_table_proceeding extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%proceeding}}',
            [
                'id' => $this->primaryKey(),
                'proc_name' => $this->string(200)->notNull(),
                'date_start' => $this->date()->notNull(),
                'date_end' => $this->date()->notNull(),
                'image_file' => $this->text()->notNull(),
                'proc_url' => $this->string(50)->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%proceeding}}');
    }
}
