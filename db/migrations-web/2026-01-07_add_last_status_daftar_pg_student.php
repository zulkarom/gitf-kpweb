<?php

class m20260107_add_last_status_daftar_pg_student
{
    public function up()
    {
        $db = \Yii::$app->db;

        // Add the last_status_daftar column to pg_student
        $db->createCommand("\n            ALTER TABLE `pg_student`\n              ADD COLUMN `last_status_daftar` INT NULL AFTER `user_id`;\n        ")->execute();

        // Optional: backfill logic could go here if needed in future
        // e.g. copy from current semester registrations
    }
}
