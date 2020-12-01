<?php

use yii\db\Migration;

class m201127_085640_0085_create_table_staff_department_name extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%staff_department_name}}',
            [
                'dep_id' => $this->primaryKey(),
                'department_name' => $this->string(250)->notNull(),
                'department_name_bi' => $this->string(250)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%staff_department_name}}');
    }
}
