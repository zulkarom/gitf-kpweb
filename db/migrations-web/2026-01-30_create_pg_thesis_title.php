<?php

class m20260130_create_pg_thesis_title
{
    public function up()
    {
        $db = \Yii::$app->db;
        $table = 'pg_thesis_title';

        $exists = (int)$db->createCommand("SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t", [
            ':t' => $table,
        ])->queryScalar();

        if ($exists > 0) {
            return;
        }

        $db->createCommand("\n            CREATE TABLE `pg_thesis_title` (\n              `id` INT(11) NOT NULL AUTO_INCREMENT,\n              `thesis_title` VARCHAR(500) NOT NULL,\n              `created_at` INT(11) NULL,\n              `updated_at` INT(11) NULL,\n              PRIMARY KEY (`id`),\n              UNIQUE KEY `uq_pg_thesis_title_thesis_title` (`thesis_title`)\n            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;\n        ")->execute();
    }
}
