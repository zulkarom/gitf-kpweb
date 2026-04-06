<?php

use yii\db\Migration;

class m260204_123000_create_table_moderasi_course_checker extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%mod_course_checker}}',
            [
                'id' => $this->primaryKey(),
                'offered_id' => $this->integer()->notNull(),
                'checker1_staff_id' => $this->integer()->null(),
                'checker2_staff_id' => $this->integer()->null(),
                'updated_at' => $this->dateTime()->notNull(),
                'updated_by' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('idx-mod_course_checker-offered_id', '{{%mod_course_checker}}', 'offered_id', true);
        $this->createIndex('idx-mod_course_checker-checker1_staff_id', '{{%mod_course_checker}}', 'checker1_staff_id');
        $this->createIndex('idx-mod_course_checker-checker2_staff_id', '{{%mod_course_checker}}', 'checker2_staff_id');
    }

    public function down()
    {
        $this->dropTable('{{%mod_course_checker}}');
    }
}
