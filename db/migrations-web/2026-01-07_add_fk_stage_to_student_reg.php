<?php

class m20260107_add_fk_stage_to_student_reg
{
    public function up()
    {
        $db = \Yii::$app->db;

        $db->createCommand("\n            ALTER TABLE `pg_student_stage`\n              ADD CONSTRAINT `fk_pg_student_stage_student_reg`\n                FOREIGN KEY (`student_id`, `semester_id`)\n                REFERENCES `pg_student_reg`(`student_id`, `semester_id`)\n                ON UPDATE CASCADE ON DELETE RESTRICT;\n        ")->execute();
    }
}
