<?php

class m20260406_add_code_urlredirect
{
    public function up()
    {
        $db = \Yii::$app->db;
        $table = 'urlredirect';

        $exists = (int)$db->createCommand("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = 'code'", [
            ':t' => $table,
        ])->queryScalar();

        if ($exists > 0) {
            return;
        }

        $db->createCommand("ALTER TABLE `urlredirect` ADD COLUMN `code` VARCHAR(16) NULL DEFAULT NULL")->execute();
        $db->createCommand("CREATE UNIQUE INDEX `idx-urlredirect-code-unique` ON `urlredirect` (`code`)")->execute();
    }
}
