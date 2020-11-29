<?php

use yii\db\Migration;

class m201127_085640_0087_create_table_staff_education extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%staff_education}}',
            [
                'id' => $this->primaryKey(),
                'edu_staff' => $this->integer()->notNull(),
                'edu_level' => $this->integer()->notNull(),
                'edu_qualification' => $this->string(150)->notNull(),
                'edu_institution' => $this->string(150)->notNull(),
                'edu_year' => $this->date()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%staff_education}}');
    }
}
