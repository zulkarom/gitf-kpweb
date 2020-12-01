<?php

use yii\db\Migration;

class m201127_085639_0053_create_table_sp_clo_verb extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_clo_verb}}',
            [
                'id' => $this->primaryKey(),
                'verb' => $this->string(100)->notNull(),
                'verb_bi' => $this->string(100)->notNull(),
                'C1' => $this->boolean()->notNull()->defaultValue('0'),
                'C2' => $this->boolean()->notNull()->defaultValue('0'),
                'C3' => $this->boolean()->notNull()->defaultValue('0'),
                'C4' => $this->boolean()->notNull()->defaultValue('0'),
                'C5' => $this->boolean()->notNull()->defaultValue('0'),
                'C6' => $this->boolean()->notNull()->defaultValue('0'),
                'A1' => $this->boolean()->notNull()->defaultValue('0'),
                'A2' => $this->boolean()->notNull()->defaultValue('0'),
                'A3' => $this->boolean()->notNull()->defaultValue('0'),
                'A4' => $this->boolean()->notNull()->defaultValue('0'),
                'A5' => $this->boolean()->notNull()->defaultValue('0'),
                'P1' => $this->boolean()->notNull()->defaultValue('0'),
                'P2' => $this->boolean()->notNull()->defaultValue('0'),
                'P3' => $this->boolean()->notNull()->defaultValue('0'),
                'P4' => $this->boolean()->notNull()->defaultValue('0'),
                'P5' => $this->boolean()->notNull()->defaultValue('0'),
                'P6' => $this->boolean()->notNull()->defaultValue('0'),
                'P7' => $this->boolean()->notNull()->defaultValue('0'),
                'L0' => $this->boolean()->notNull(),
                'L1' => $this->boolean()->notNull(),
                'L2' => $this->boolean()->notNull(),
                'L3' => $this->boolean()->notNull(),
                'L4' => $this->boolean()->notNull(),
                'published' => $this->boolean()->notNull()->defaultValue('1'),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_clo_verb}}');
    }
}
