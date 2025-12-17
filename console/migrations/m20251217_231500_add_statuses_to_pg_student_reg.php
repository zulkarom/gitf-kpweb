<?php

use yii\db\Migration;

class m20251217_231500_add_statuses_to_pg_student_reg extends Migration
{
    public function up()
    {
        $this->addColumn('{{%pg_student_reg}}', 'status_daftar', $this->tinyInteger()->null());
        $this->addColumn('{{%pg_student_reg}}', 'status_aktif', $this->tinyInteger()->null());

        $this->createIndex(
            'ux_pg_student_reg_student_semester',
            '{{%pg_student_reg}}',
            ['student_id', 'semester_id'],
            true
        );
    }

    public function down()
    {
        $this->dropIndex('ux_pg_student_reg_student_semester', '{{%pg_student_reg}}');

        $this->dropColumn('{{%pg_student_reg}}', 'status_aktif');
        $this->dropColumn('{{%pg_student_reg}}', 'status_daftar');
    }
}
