<?php

use yii\db\Migration;

class m201127_085640_0081_create_table_sp_transferable extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_transferable}}',
            [
                'id' => $this->primaryKey(),
                'transferable_text' => $this->text()->notNull(),
                'transferable_text_bi' => $this->text()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_transferable}}');
    }
}
