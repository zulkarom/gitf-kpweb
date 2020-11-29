<?php

use yii\db\Migration;

class m201127_085637_0007_create_table_country extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%country}}',
            [
                'id' => $this->primaryKey(5),
                'country_code' => $this->char(2)->notNull()->defaultValue(''),
                'country_name' => $this->string(45)->notNull()->defaultValue(''),
                'currency_code' => $this->char(3),
            ],
            $tableOptions
        );

        $this->createIndex('country_code', '{{%country}}', ['country_code'], true);
    }

    public function down()
    {
        $this->dropTable('{{%country}}');
    }
}
