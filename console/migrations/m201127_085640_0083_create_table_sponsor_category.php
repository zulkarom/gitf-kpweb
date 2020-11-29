<?php

use yii\db\Migration;

class m201127_085640_0083_create_table_sponsor_category extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sponsor_category}}',
            [
                'id' => $this->primaryKey(),
                'category_name' => $this->string(100)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sponsor_category}}');
    }
}
