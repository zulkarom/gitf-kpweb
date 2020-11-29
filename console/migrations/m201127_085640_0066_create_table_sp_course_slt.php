<?php

use yii\db\Migration;

class m201127_085640_0066_create_table_sp_course_slt extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_slt}}',
            [
                'id' => $this->primaryKey(),
                'crs_version_id' => $this->integer()->notNull(),
                'lecture_jam' => $this->double()->notNull(),
                'lecture_mggu' => $this->tinyInteger(2)->notNull(),
                'tutorial_jam' => $this->double()->notNull(),
                'tutorial_mggu' => $this->tinyInteger(2)->notNull(),
                'practical_jam' => $this->double()->notNull(),
                'practical_mggu' => $this->tinyInteger(2)->notNull(),
                'others_jam' => $this->double()->notNull(),
                'others_mggu' => $this->tinyInteger(2)->notNull(),
                'independent' => $this->double()->notNull(),
                'nf2f' => $this->double()->notNull(),
                'is_practical' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_slt}}');
    }
}
