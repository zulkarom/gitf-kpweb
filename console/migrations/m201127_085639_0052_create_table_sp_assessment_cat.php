<?php

use yii\db\Migration;

class m201127_085639_0052_create_table_sp_assessment_cat extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_assessment_cat}}',
            [
                'id' => $this->primaryKey(),
                'cat_name' => $this->string(100)->notNull(),
                'cat_name_bi' => $this->string(100)->notNull(),
                'form_sum' => $this->boolean()->notNull(),
                'is_direct' => $this->boolean()->notNull(),
                'showing' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_assessment_cat}}');
    }
}
