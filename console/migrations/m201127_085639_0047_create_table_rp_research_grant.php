<?php

use yii\db\Migration;

class m201127_085639_0047_create_table_rp_research_grant extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%rp_research_grant}}',
            [
                'id' => $this->primaryKey(),
                'gra_name' => $this->string(200)->notNull(),
                'gra_abbr' => $this->string(20)->notNull(),
                'gra_order' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%rp_research_grant}}');
    }
}
