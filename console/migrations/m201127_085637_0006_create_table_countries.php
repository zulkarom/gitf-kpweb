<?php

use yii\db\Migration;

class m201127_085637_0006_create_table_countries extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%countries}}',
            [
                'idCountry' => $this->primaryKey(5),
                'countryCode' => $this->char(2)->notNull()->defaultValue(''),
                'countryName' => $this->string(45)->notNull()->defaultValue(''),
                'currencyCode' => $this->char(3),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%countries}}');
    }
}
