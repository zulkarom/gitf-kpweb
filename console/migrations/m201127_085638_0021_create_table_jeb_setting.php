<?php

use yii\db\Migration;

class m201127_085638_0021_create_table_jeb_setting extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%jeb_setting}}',
            [
                'id' => $this->primaryKey(),
                'template_file' => $this->string(100)->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%jeb_setting}}');
    }
}
