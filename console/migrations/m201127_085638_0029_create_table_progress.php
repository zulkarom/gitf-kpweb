<?php

use yii\db\Migration;

class m201127_085638_0029_create_table_progress extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%progress}}',
            [
                'tm' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'stage' => $this->integer(2)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%progress}}');
    }
}
