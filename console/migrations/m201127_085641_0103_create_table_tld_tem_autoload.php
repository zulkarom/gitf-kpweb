<?php

use yii\db\Migration;

class m201127_085641_0103_create_table_tld_tem_autoload extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%tld_tem_autoload}}',
            [
                'id' => $this->primaryKey(),
                'staff_id' => $this->integer()->notNull(),
                'running_name' => $this->string(100)->notNull(),
                'load_hour' => $this->integer()->notNull()->defaultValue('0'),
                'stop_run' => $this->boolean()->notNull()->defaultValue('0'),
                'no_lecture' => $this->boolean()->notNull()->defaultValue('0'),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%tld_tem_autoload}}');
    }
}
