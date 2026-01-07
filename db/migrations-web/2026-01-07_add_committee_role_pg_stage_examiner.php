<?php

class m20260107_add_committee_role_pg_stage_examiner
{
    public function up()
    {
        $db = \Yii::$app->db;

        $db->createCommand("\n            ALTER TABLE `pg_stage_examiner`\n              ADD COLUMN `committee_role` TINYINT(1) NOT NULL DEFAULT 3 AFTER `stage_id`;\n        ")->execute();
    }
}
