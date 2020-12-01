<?php

use yii\db\Migration;

class m201127_085638_0020_create_table_jeb_review_form extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%jeb_review_form}}',
            [
                'id' => $this->primaryKey(),
                'form_quest' => $this->text()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%jeb_review_form}}');
    }
}
