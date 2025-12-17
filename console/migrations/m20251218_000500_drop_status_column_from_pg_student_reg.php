<?php

use yii\db\Migration;

class m20251218_000500_drop_status_column_from_pg_student_reg extends Migration
{
    public function safeUp()
    {
        try {
            $this->dropColumn('{{%pg_student_reg}}', 'status');
        } catch (\Throwable $e) {
            // ignore if column does not exist
        }
    }

    public function safeDown()
    {
        return false;
    }
}
