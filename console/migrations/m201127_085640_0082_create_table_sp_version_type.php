<?php

use yii\db\Migration;

class m201127_085640_0082_create_table_sp_version_type extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_version_type}}',
            [
                'id' => $this->primaryKey(),
                'type_name' => $this->string(200)->notNull(),
                'plo_num' => $this->tinyInteger(4)->notNull(),
                'plo1' => $this->text()->notNull(),
                'plo2' => $this->text()->notNull(),
                'plo3' => $this->text()->notNull(),
                'plo4' => $this->text()->notNull(),
                'plo5' => $this->text()->notNull(),
                'plo6' => $this->text()->notNull(),
                'plo7' => $this->text()->notNull(),
                'plo8' => $this->text()->notNull(),
                'plo9' => $this->text()->notNull(),
                'plo10' => $this->text()->notNull(),
                'plo11' => $this->text()->notNull(),
                'plo12' => $this->text()->notNull(),
                'plo1_bi' => $this->text()->notNull(),
                'plo2_bi' => $this->text()->notNull(),
                'plo3_bi' => $this->text()->notNull(),
                'plo4_bi' => $this->text()->notNull(),
                'plo5_bi' => $this->text()->notNull(),
                'plo6_bi' => $this->text()->notNull(),
                'plo7_bi' => $this->text()->notNull(),
                'plo8_bi' => $this->text()->notNull(),
                'plo9_bi' => $this->text()->notNull(),
                'plo10_bi' => $this->text()->notNull(),
                'plo11_bi' => $this->text()->notNull(),
                'plo12_bi' => $this->text()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_version_type}}');
    }
}
