<?php

class m20260107_add_is_active_pg_student_sv
{
    public function up()
    {
        $db = \Yii::$app->db;

        $db->createCommand("\n            ALTER TABLE `pg_student_sv`\n              ADD COLUMN `is_active` TINYINT(1) NOT NULL DEFAULT 1 AFTER `sv_role`;\n        ")->execute();
    }
}
