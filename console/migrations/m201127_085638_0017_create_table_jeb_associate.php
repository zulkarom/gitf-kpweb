<?php

use yii\db\Migration;

class m201127_085638_0017_create_table_jeb_associate extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%jeb_associate}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'institution' => $this->string(200)->notNull(),
                'country_id' => $this->integer()->notNull(),
                'admin_creation' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%jeb_associate}}');
    }
}
