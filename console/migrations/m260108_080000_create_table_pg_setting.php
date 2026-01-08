<?php

use yii\db\Migration;

class m260108_080000_create_table_pg_setting extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%pg_setting}}', [
            'id' => $this->primaryKey(),
            'module' => $this->string(32)->notNull(),
            'color' => $this->string(10)->notNull(),
            'min_value' => $this->integer()->notNull(),
            'max_value' => $this->integer()->null(),
            'updated_at' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->null(),
        ], $tableOptions);

        $this->createIndex('idx_pg_setting_module', '{{%pg_setting}}', 'module');
        $this->createIndex('ux_pg_setting_module_color', '{{%pg_setting}}', ['module', 'color'], true);

        $now = time();
        $rows = [
            ['module' => 'supervisor', 'color' => 'green', 'min_value' => 0, 'max_value' => 3, 'updated_at' => $now, 'updated_by' => null],
            ['module' => 'supervisor', 'color' => 'yellow', 'min_value' => 4, 'max_value' => 7, 'updated_at' => $now, 'updated_by' => null],
            ['module' => 'supervisor', 'color' => 'red', 'min_value' => 8, 'max_value' => null, 'updated_at' => $now, 'updated_by' => null],
            ['module' => 'exam_committee', 'color' => 'green', 'min_value' => 0, 'max_value' => 3, 'updated_at' => $now, 'updated_by' => null],
            ['module' => 'exam_committee', 'color' => 'yellow', 'min_value' => 4, 'max_value' => 7, 'updated_at' => $now, 'updated_by' => null],
            ['module' => 'exam_committee', 'color' => 'red', 'min_value' => 8, 'max_value' => null, 'updated_at' => $now, 'updated_by' => null],
        ];
        $this->batchInsert('{{%pg_setting}}', ['module', 'color', 'min_value', 'max_value', 'updated_at', 'updated_by'], array_map(function ($r) {
            return [$r['module'], $r['color'], $r['min_value'], $r['max_value'], $r['updated_at'], $r['updated_by']];
        }, $rows));
    }

    public function down()
    {
        $this->dropTable('{{%pg_setting}}');
    }
}
