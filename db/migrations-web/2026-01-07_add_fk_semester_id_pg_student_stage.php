<?php

class m20260107_add_fk_semester_id_pg_student_stage
{
    public function up()
    {
        $db = \Yii::$app->db;

        $db->createCommand("\n            ALTER TABLE `pg_student_stage`\n              ADD CONSTRAINT `fk_pg_student_stage_semester`\n                FOREIGN KEY (`semester_id`) REFERENCES `semester`(`id`)\n                ON UPDATE CASCADE ON DELETE RESTRICT;\n        ")->execute();
    }
}
