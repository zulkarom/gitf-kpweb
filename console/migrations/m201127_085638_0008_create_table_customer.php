<?php

use yii\db\Migration;

class m201127_085638_0008_create_table_customer extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%customer}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'phone' => $this->string(100)->notNull(),
                'biz_type' => $this->integer()->notNull(),
                'expired_date' => $this->date()->notNull(),
                'sale_amt' => $this->double()->notNull(),
                'sale_at' => $this->integer()->notNull(),
                'is_block' => $this->boolean()->notNull()->defaultValue('1'),
                'updated_at' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%customer}}');
    }
}
