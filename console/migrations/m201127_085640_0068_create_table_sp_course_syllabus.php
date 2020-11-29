<?php

use yii\db\Migration;

class m201127_085640_0068_create_table_sp_course_syllabus extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_syllabus}}',
            [
                'id' => $this->primaryKey(),
                'crs_version_id' => $this->integer()->notNull(),
                'clo' => $this->string()->notNull(),
                'week_num' => $this->string(20)->notNull(),
                'duration' => $this->boolean()->notNull()->defaultValue('1'),
                'topics' => $this->text()->notNull(),
                'pnp_lecture' => $this->double()->notNull(),
                'pnp_tutorial' => $this->double()->notNull(),
                'pnp_practical' => $this->double()->notNull(),
                'pnp_others' => $this->double()->notNull(),
                'tech_lecture' => $this->double()->notNull(),
                'tech_tutorial' => $this->double()->notNull(),
                'tech_practical' => $this->double()->notNull(),
                'tech_others' => $this->double()->notNull(),
                'independent' => $this->double()->notNull(),
                'assessment' => $this->double()->notNull(),
                'nf2f' => $this->double()->notNull(),
                'syl_order' => $this->integer()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_syllabus}}');
    }
}
