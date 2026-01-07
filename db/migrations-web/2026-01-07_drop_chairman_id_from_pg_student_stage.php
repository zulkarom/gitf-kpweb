<?php

class m20260107_drop_chairman_id_from_pg_student_stage
{
    public function up()
    {
        $db = \Yii::$app->db;

        $db->createCommand("\n            ALTER TABLE `pg_student_stage`\n              DROP COLUMN `chairman_id`;\n        ")->execute();
    }
}
