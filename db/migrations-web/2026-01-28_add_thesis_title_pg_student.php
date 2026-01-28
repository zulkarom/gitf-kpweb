<?php

class m20260128_add_thesis_title_pg_student
{
    public function up()
    {
        $db = \Yii::$app->db;
        $table = 'pg_student_stage';

        $exists = (int)$db->createCommand("SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t", [
            ':t' => $table,
        ])->queryScalar();

        if ($exists === 0) {
            return;
        }

        $has = (int)$db->createCommand(
            "SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = 'thesis_title'",
            [':t' => $table]
        )->queryScalar();

        if ($has === 0) {
            $db->createCommand("ALTER TABLE `pg_student_stage` ADD COLUMN `thesis_title` VARCHAR(500) NULL AFTER `remark`;")->execute();
        }
    }
}
