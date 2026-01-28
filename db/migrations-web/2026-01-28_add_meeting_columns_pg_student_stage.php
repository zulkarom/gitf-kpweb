<?php

class m20260128_add_meeting_columns_pg_student_stage
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

        $cols = [
            'stage_time' => "ALTER TABLE `pg_student_stage` ADD COLUMN `stage_time` TIME NULL AFTER `stage_date`;",
            'location' => "ALTER TABLE `pg_student_stage` ADD COLUMN `location` VARCHAR(255) NULL AFTER `stage_time`;",
            'meeting_link' => "ALTER TABLE `pg_student_stage` ADD COLUMN `meeting_link` VARCHAR(500) NULL AFTER `location`;",
            'meeting_mode' => "ALTER TABLE `pg_student_stage` ADD COLUMN `meeting_mode` VARCHAR(20) NULL AFTER `meeting_link`;",
        ];

        foreach ($cols as $col => $sql) {
            $has = (int)$db->createCommand(
                "SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = :c",
                [':t' => $table, ':c' => $col]
            )->queryScalar();

            if ($has === 0) {
                $db->createCommand($sql)->execute();
            }
        }
    }
}
