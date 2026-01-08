<?php

class m20260108_create_table_pg_setting
{
    public function up()
    {
        $db = \Yii::$app->db;

        $db->createCommand("
            CREATE TABLE IF NOT EXISTS `pg_setting` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `module` VARCHAR(32) NOT NULL,
              `color` VARCHAR(10) NOT NULL,
              `min_value` INT NOT NULL,
              `max_value` INT NULL,
              `updated_at` INT NOT NULL,
              `updated_by` INT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `ux_pg_setting_module_color` (`module`,`color`),
              KEY `idx_pg_setting_module` (`module`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ")->execute();

        $now = time();

        $db->createCommand("INSERT INTO `pg_setting` (`module`,`color`,`min_value`,`max_value`,`updated_at`,`updated_by`) VALUES
            ('supervisor','green',0,3,:now,NULL),
            ('supervisor','yellow',4,7,:now,NULL),
            ('supervisor','red',8,NULL,:now,NULL),
            ('exam_committee','green',0,3,:now,NULL),
            ('exam_committee','yellow',4,7,:now,NULL),
            ('exam_committee','red',8,NULL,:now,NULL)
            ON DUPLICATE KEY UPDATE
              `min_value`=VALUES(`min_value`),
              `max_value`=VALUES(`max_value`),
              `updated_at`=VALUES(`updated_at`),
              `updated_by`=VALUES(`updated_by`);
        ")->bindValue(':now', $now)->execute();
    }
}
