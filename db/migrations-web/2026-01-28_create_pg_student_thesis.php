<?php

class m20260128_create_pg_student_thesis
{
    public function up()
    {
        $db = \Yii::$app->db;
        $table = 'pg_student_thesis';

        $exists = (int)$db->createCommand("SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t", [
            ':t' => $table,
        ])->queryScalar();

        if ($exists > 0) {
            return;
        }

        $db->createCommand("\n            CREATE TABLE `pg_student_thesis` (\n              `id` INT(11) NOT NULL AUTO_INCREMENT,\n              `student_id` INT(11) NOT NULL,\n              `thesis_title` VARCHAR(500) NULL,\n              `date_applied` DATE NULL,\n              `is_active` TINYINT(1) NOT NULL DEFAULT 1,\n              `created_at` INT(11) NULL,\n              `updated_at` INT(11) NULL,\n              PRIMARY KEY (`id`),\n              KEY `idx_pg_student_thesis_student_id` (`student_id`)\n            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;\n        ")->execute();

        try {
            $db->createCommand("\n                ALTER TABLE `pg_student_thesis`\n                  ADD CONSTRAINT `fk_pg_student_thesis_student`\n                    FOREIGN KEY (`student_id`) REFERENCES `pg_student`(`id`)\n                    ON UPDATE CASCADE ON DELETE CASCADE;\n            ")->execute();
        } catch (\Throwable $e) {
        }
    }
}
