<?php

use yii\db\Migration;

class m20251218_001000_drop_statuses_from_pg_student extends Migration
{
    public function safeUp()
    {
        try {
            $this->dropColumn('{{%pg_student}}', 'status_daftar');
        } catch (\Throwable $e) {
            // ignore if column does not exist
        }

        try {
            $this->dropColumn('{{%pg_student}}', 'status_aktif');
        } catch (\Throwable $e) {
            // ignore if column does not exist
        }
    }

    public function safeDown()
    {
        return false;
    }
}
