<?php

class m20260130_add_remark_pg_student_reg
{
    public function up()
    {
        $db = \Yii::$app->db;
        $table = 'pg_student_reg';

        $exists = (int)$db->createCommand(
            "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t",
            [':t' => $table]
        )->queryScalar();

        if ($exists === 0) {
            return;
        }

        $has = (int)$db->createCommand(
            "SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = 'remark'",
            [':t' => $table]
        )->queryScalar();

        if ($has === 0) {
            $db->createCommand("ALTER TABLE `pg_student_reg` ADD COLUMN `remark` TEXT NULL;")->execute();
        }
    }
}
